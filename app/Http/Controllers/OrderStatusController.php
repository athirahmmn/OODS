<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderStatusController extends Controller
{
    public function index(Request $request)
    {
        $userID = Auth::id(); // Get the currently logged-in user's ID
        
        // Start the query
        $query = Order::where('userID', $userID);
    
        // Filter by year if selected
        if ($request->has('yearFilter') && $request->yearFilter) {
            $query->whereYear('orderDate', $request->yearFilter);
        }
    
        // Filter by month if selected
        if ($request->has('monthFilter') && $request->monthFilter) {
            $query->whereMonth('orderDate', $request->monthFilter);
        }
    
        // Search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('orderID', 'like', "%$searchTerm%")
                  ->orWhere('total', 'like', "%$searchTerm%")
                  ->orWhere('orderDate', 'like', "%$searchTerm%")
                  ->orWhere('orderStatus', 'like', "%$searchTerm%");
            });
        }
    
        // Get filtered orders
        $orders = $query->get();
        
        return view('supervisor.orderStatus', ['orders' => $orders]);
    }    

    public function orderStatusDetails($orderID)
{
    $order = Order::with(['orderDetails.stock'])->findOrFail($orderID);
    $orderDetails = $order->orderDetails;

    return response()->json([
        'order' => $order,
        'orderDetails' => $orderDetails->map(function ($detail) {
            return [
                'stockName' => $detail->stock->stocksName ?? 'N/A',
                'quantity' => $detail->quantity,
            ];
        }),
    ]);
}

    public function getRejectionReason($orderId)
    {
        $order = Order::find($orderId);

        if ($order && $order->orderStatus == 'Rejected') {
            return response()->json(['reason' => $order->reason], 200);
        }

        return response()->json(['message' => 'Rejection reason not found.'], 404);
    }

    public function cancelOrder($orderID)
    {
        try {
            // Find the order and delete it
            $order = Order::with('orderDetails')->findOrFail($orderID);

            // Deleting the order will automatically delete related order details due to foreign key constraints
            $order->delete();

            Log::info('Order with ID ' . $orderID . ' has been successfully cancelled and removed.');

            return response()->json(['message' => 'Order cancelled successfully.']);
        } catch (Exception $e) {
            Log::error('Failed to cancel order with ID ' . $orderID . ': ' . $e->getMessage());
            return response()->json(['message' => 'Failed to cancel the order. Please try again later.'], 500);
        }
    }
}