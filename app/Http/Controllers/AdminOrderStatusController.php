<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Facades\Log;

class AdminOrderStatusController extends Controller
{
    public function index()
    {
        // Fetch orders with related user and order details
        $orders = Order::with(['user', 'orderDetails.stock'])->get();

        // Pass orders to the view
        return view('admin.updateOrderStatus', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Starting update process for Order ID: ' . $id);
    
        $request->validate([
            'orderStatus' => 'required|in:Pending,Approved,Rejected',
            'reason' => 'nullable|string|max:255',
        ]);
    
        try {
            $order = Order::with('orderDetails.stock.warehouse')->findOrFail($id);
            Log::info('Fetched order successfully:', ['orderID' => $id, 'orderStatus' => $order->orderStatus]);
    
            if ($request->input('orderStatus') === 'Rejected') {
                Log::info('Processing Rejected status for Order ID: ' . $id);
    
                $isSufficient = true;
    
                foreach ($order->orderDetails as $detail) {
                    if ($detail->quantity > $detail->stock->warehouse->stocksQuantity) {
                        $isSufficient = false;
                        Log::warning('Stock insufficient for Order Detail ID: ' . $detail->id);
                        break;
                    }
                }
    
                if ($isSufficient && !$request->filled('reason')) {
                    Log::error('Reason is missing for rejecting an order with sufficient stock.', ['orderID' => $id]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'A reason is required for rejecting an order with sufficient stock.',
                    ], 400);
                }
    
                $order->reason = $request->input('reason');
                Log::info('Added reason for rejection:', ['reason' => $request->input('reason')]);
            }
    
            if ($request->input('orderStatus') === 'Approved') {
                Log::info('Processing Approved status for Order ID: ' . $id);
    
                foreach ($order->orderDetails as $detail) {
                    if ($detail->quantity > $detail->stock->warehouse->stocksQuantity) {
                        Log::error('Insufficient stock for approving Order ID: ' . $id);
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Insufficient stock. Cannot approve this order.',
                        ], 400);
                    }
                }
            }
    
            $order->orderStatus = $request->input('orderStatus');
            $order->save();
    
            Log::info('Order status updated successfully.', [
                'orderID' => $id,
                'newStatus' => $order->orderStatus,
            ]);
    
            return response()->json([
                'status' => 'success',
                'orderID' => $order->orderID,
                'orderStatus' => $order->orderStatus,
                'success_message' => $order->orderStatus === 'Rejected'
                    ? 'The order has been successfully rejected.'
                    : 'The order has been successfully approved.',
            ]);
        } catch (\Exception $e) {
            Log::error('Exception occurred while updating order status.', [
                'orderID' => $id,
                'error' => $e->getMessage(),
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update the order status.',
            ], 500);
        }
    }
    public function getRejectionReason($orderId)
    {
        $order = Order::find($orderId);

        if ($order && $order->orderStatus == 'Rejected') {
            return response()->json(['reason' => $order->reason], 200);
        }

        return response()->json(['message' => 'Rejection reason not found.'], 404);
    }

    public function orderDetails($orderID)
    {
        // Fetch order details along with stock information
        $order = Order::with(['user', 'orderDetails.stock'])->findOrFail($orderID);
        $orderDetails = $order->orderDetails;

        return response()->json([
            'username' => $order->user->userName,
            'order' => $order,
            'orderDetails' => $orderDetails->map(function ($detail) {
                return [
                    'stockName' => $detail->stock->stocksName ?? 'N/A',
                    'requestedQuantity' => $detail->quantity,
                    'availableQuantity' => $detail->stock->warehouse->stocksQuantity ?? 0,
                ];
            }),
        ]);
    }

    public function createDelivery(Request $request)
    {
        $orderIDs = $request->input('orderIDs');

        // Fetch all orders with the provided order IDs
        $orders = Order::whereIn('orderID', $orderIDs)->get();

        // Ensure all orders have "Approved" status
        foreach ($orders as $order) {
            if ($order->orderStatus !== 'Approved') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'All selected orders must have an "Approved" status to proceed with delivery.'
                ]);
            }
        }

        // Get the user ID of the first order to compare with others
        $firstUserID = $orders->first()->userID;

        // Check if all orders have the same user ID
        foreach ($orders as $order) {
            if ($order->userID !== $firstUserID) {
                // Return an error response if there's a mismatch in user IDs
                return response()->json([
                    'status' => 'error',
                    'message' => 'Selected orders must belong to the same user to arrange a delivery.'
                ]);
            }
        }

        // Proceed with delivery creation if all user IDs match
        $delivery = new Delivery();
        $delivery->userID = $firstUserID; // Store userID
        $delivery->save();

        // Associate the selected orders with this delivery
        foreach ($orders as $order) {
            $order->deliveryID = $delivery->deliveryID;
            $order->save();
        }

        return response()->json(['status' => 'success']);
    }

    public function checkStockAvailability($orderID)
    {
        $order = Order::with(['orderDetails.stock.warehouse'])->findOrFail($orderID);

        $isSufficient = true;

        foreach ($order->orderDetails as $detail) {
            if ($detail->quantity > $detail->stock->warehouse->stocksQuantity) {
                $isSufficient = false;
                break;
            }
        }

        return response()->json([
            'isSufficient' => $isSufficient,
            'orderID' => $order->orderID,
        ]);
    }
}