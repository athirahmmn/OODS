<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\StockOutlet;
use App\Models\Stock;
use App\Models\Delivery;
use Illuminate\Support\Facades\Log;  // Import Log facade

class SupervisorController extends Controller
{
    public function dashboard()
    {
        $this->checkAlerts();
        $this->addNewStockMessages();
    
        // Count the number of StockOutlet rows for the logged-in user
        $userID = Auth::id();  // Get the logged-in user ID
        $totalStocks = StockOutlet::where('userID', $userID)->count();  // Count rows for that user
    
        $pendingOrders = Order::where('orderStatus', 'Pending')->count();
        $pendingDeliveries = Delivery::where('deliveryStatus', 'Not Updated Yet')->count();
        $deliveriesNotArrived = Delivery::where('deliveryStatus', '!=', 'Delivered')->count();
    
        $newStocksCount = $this->countNewStocks();
    
        $alerts = session()->get('alerts', []);
        $messages = session()->get('messages', []);
        session()->forget('alerts');
        session()->forget('messages');
    
        $alerts = array_reverse($alerts);
        $messages = array_reverse($messages);
    
        return view('supervisor.dashboard', compact('totalStocks', 'deliveriesNotArrived', 'pendingDeliveries', 'pendingOrders', 'alerts', 'messages', 'newStocksCount'))
            ->with('info-message', session('info-message'));
    }    

    protected function checkAlerts()
    {
        // Fetch all stocks with their respective outlets
        $stocks = Stock::with('outlets')->get();
        
        // Get the existing alerts from session
        $alerts = session()->get('alerts', []);
        
        // Loop through the stocks to check for low stock quantities in the context of StockOutlet
        foreach ($stocks as $stock) {
            $stockOutlets = $stock->outlets;
    
            foreach ($stockOutlets as $outlet) {
                if ($outlet->stocksQuantity > 0 && $outlet->stocksQuantity < 5) {
                    // Add alert if not already present
                    $alertExists = collect($alerts)->contains(function ($alert) use ($outlet, $stock) {
                        return isset($alert['stocksName']) && $alert['stocksName'] === $stock->stocksName && $alert['userID'] === $outlet->userID;
                    });
    
                    if (!$alertExists) {
                        $alerts[] = [
                            'type' => 'danger',
                            'message' => "Stock quantity for {$stock->stocksName} has reached the minimum amount for your outlet. Please request a new order.",
                            'code' => 'STOCK_MINIMUM',
                            'stocksName' => $stock->stocksName,
                            'stockId' => $stock->id,
                            'outletId' => $outlet->id,
                            'userID' => $outlet->userID,
                        ];
                    }
                }
            }
        }
    
        // Add other alerts (order and delivery updates)
        $orders = Order::where('updated_at', '>=', now()->subDay())->get();
        foreach ($orders as $order) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "Order status for Order ID {$order->orderID} has been updated.",
                'code' => 'ORDER_STATUS_UPDATED',
                'orderId' => $order->id
            ];
        }
    
        $deliveries = Delivery::whereIn('deliveryStatus', ['Preparing for Delivery', 'Out for Delivery', 'Shipped', 'Delivered'])
                              ->where('updated_at', '>=', now()->subDay())
                              ->get();
        foreach ($deliveries as $delivery) {
            $alerts[] = [
                'type' => 'success',
                'message' => "Delivery status for Delivery ID {$delivery->deliveryID} has been updated to {$delivery->deliveryStatus}.",
                'code' => 'DELIVERY_STATUS_UPDATED',
                'deliveryId' => $delivery->id
            ];
        }
    
        // Sort alerts to ensure danger alerts are at the top
        usort($alerts, function ($a, $b) {
            // Priority: danger alerts should come first
            if ($a['type'] === 'danger' && $b['type'] !== 'danger') {
                return -1;
            } elseif ($a['type'] !== 'danger' && $b['type'] === 'danger') {
                return 1;
            }
            return 0;
        });
    
        // Store the updated alerts in the session
        session()->put('alerts', $alerts);
    }    
    
    protected function addNewStockMessages()
    {
        $newStocks = Stock::where('created_at', '>=', now()->subDay())->get();

        foreach ($newStocks as $newStock) {
            session()->flash('info-message', "New stock '{$newStock->stocksName}' has been added. Please check the stock.");
        }

        return redirect()->route('supervisor.dashboard');
    }

    protected function countNewStocks()
    {
        return Stock::where('created_at', '>=', now()->subDay())->count();
    }
}
