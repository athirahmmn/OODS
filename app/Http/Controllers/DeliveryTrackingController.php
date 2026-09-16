<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\StockOutlet;
use App\Models\StockWarehouse;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DeliveryTrackingController extends Controller
{
    public function index()
    {
        $userID = Auth::id();

        $deliveries = Delivery::whereHas('orders', function($query) use ($userID) {
                            $query->where('userID', $userID);
                        })
                        ->with(['orders' => function($query) {
                            $query->where('orderStatus', 'Approved')->select('orderID', 'orderDate', 'orderStatus', 'userID', 'deliveryID');
                        }])
                        ->get();

        return view('supervisor.deliveryTracking', compact('deliveries'));
    }

    public function markAsReceived($deliveryID)
    {
        try {
            // Retrieve the orders associated with the given deliveryID
            $orders = Order::where('deliveryID', $deliveryID)->get();
    
            if ($orders->isEmpty()) {
                return response()->json(['error' => 'No orders found for this delivery.'], 404);
            }

            // Get the currently authenticated user's ID
            $userID = Auth::id();
    
            // Start a transaction for safe updating
            DB::beginTransaction();
    
            foreach ($orders as $order) {
                // Retrieve the order details for each order
                $orderDetails = OrderDetail::where('orderID', $order->orderID)->get();
    
                foreach ($orderDetails as $orderDetail) {
                    // Get the stocksID and requested quantity from the order details
                    $stocksID = $orderDetail->stocksID;
                    $requestedQuantity = $orderDetail->quantity;
    
                    // Log the stocksID and requested quantity for debugging
                    Log::info("Processing OrderDetail for OrderID: {$order->orderID} - StocksID: {$stocksID}, RequestedQuantity: {$requestedQuantity}");
    
                    // Find the stock outlet record by stocksID
                    $stockOutlet = StockOutlet::where('stocksID', $stocksID)
                        ->where('userID', $userID)
                        ->first();
                        
                    if ($stockOutlet) {
                        // Log the current stocksQuantity before update for debugging
                        Log::info("Current stocksQuantity for StocksID {$stocksID}: {$stockOutlet->stocksQuantity}");
    
                        // Increase the stocksQuantity by adding the requested quantity
                        $newQuantity = $stockOutlet->stocksQuantity + $requestedQuantity;
    
                        // Log the new quantity after the addition
                        Log::info("New stocksQuantity (after addition): {$newQuantity}");
    
                        // Directly save the new quantity to the model
                        $stockOutlet->stocksQuantity = $newQuantity;
                        $stockOutlet->save();
    
                        // Log confirmation after save
                        Log::info("Updated stocksQuantity for StocksID {$stocksID} to {$newQuantity}");
                    } else {
                        // Log the error if the stock outlet is not found
                        Log::error("Stock outlet not found for StocksID: {$stocksID}");
    
                        // Handle case where the stocksID is not found in the stock outlet
                        DB::rollBack();
                        return response()->json([
                            'error' => 'Stock not found for stocksID: ' . $stocksID
                        ], 404);
                    }
    
                    // Now decrease the stock quantity in the stock warehouse
                    $stockWarehouse = StockWarehouse::where('stocksID', $stocksID)->first();
    
                    if ($stockWarehouse) {
                        // Log the current warehouse stock quantity before update for debugging
                        Log::info("Current warehouse stocksQuantity for StocksID {$stocksID}: {$stockWarehouse->stocksQuantity}");
    
                        // Decrease the warehouse stock by the requested quantity
                        $newWarehouseQuantity = $stockWarehouse->stocksQuantity - $requestedQuantity;
    
                        // Ensure the quantity does not go negative
                        if ($newWarehouseQuantity < 0) {
                            DB::rollBack();
                            return response()->json(['error' => 'Insufficient stock in warehouse.'], 400);
                        }
    
                        // Log the new warehouse stock quantity after deduction
                        Log::info("New warehouse stocksQuantity (after deduction): {$newWarehouseQuantity}");
    
                        // Directly save the new quantity to the warehouse model
                        $stockWarehouse->stocksQuantity = $newWarehouseQuantity;
                        $stockWarehouse->save();
    
                        // Log confirmation after save
                        Log::info("Updated warehouse stocksQuantity for StocksID {$stocksID} to {$newWarehouseQuantity}");
                    } else {
                        // Log the error if the stock warehouse record is not found
                        Log::error("Stock warehouse not found for StocksID: {$stocksID}");
    
                        // Handle case where the stocksID is not found in the warehouse
                        DB::rollBack();
                        return response()->json([
                            'error' => 'Stock warehouse not found for stocksID: ' . $stocksID
                        ], 404);
                    }
                }
            }
    
            // Commit the transaction if everything went fine
            DB::commit();
    
            // Check if the delivery status is "Delivered"
            $delivery = Delivery::find($deliveryID);
            if ($delivery && $delivery->deliveryStatus == 'Delivered') {
                // Update the received date
                $delivery->received_date = Carbon::now();
                $delivery->save();
    
                // Return success response with orderID to trigger the success modal
                return redirect()->route('supervisor.deliveryTracking')->with([
                    'orderID' => $orders->first()->orderID,
                    'received_date' => $delivery->received_date->format('d M Y')
                ]);
            }
    
            return redirect()->route('supervisor.deliveryTracking')->with('error', 'Unable to mark order as received.');
    
        } catch (\Exception $e) {
            // Log error message and rollback transaction if something went wrong
            Log::error('Error updating stocks: ' . $e->getMessage());
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function checkOverdueDeliveries()
    {
        $oneWeekAgo = now()->subWeek();

        $overdueDeliveries = Delivery::where('deliveryStatus', 'Delivered')
            ->whereNull('received_date')
            ->where('delivered_date', '<', $oneWeekAgo)
            ->get();

        foreach ($overdueDeliveries as $delivery) {
            // Log or store an alert
            \Log::info("Delivery ID {$delivery->deliveryID} is overdue. Notify supervisor.");

            // You can optionally update a column to track alerts
            $delivery->alert_status = 'Overdue'; // Assuming you add an `alert_status` column
            $delivery->save();
        }

        return response()->json([
            'message' => 'Overdue deliveries checked',
            'overdue_deliveries' => $overdueDeliveries,
        ]);
    }
    
}
