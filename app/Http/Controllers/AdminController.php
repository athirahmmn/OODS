<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Delivery;
use App\Models\User;
use App\Models\StockWarehouse;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Generate alerts for pending orders and incomplete deliveries
        $alerts = $this->generateAlerts();

        // Dashboard metrics
        $totalStocks = StockWarehouse::count();
        $pendingOrders = Order::where('orderStatus', 'Pending')->count();
        $totalOutlets = User::count();

        Log::info('Dashboard Alerts:', $alerts);

        return view('admin.dashboard', compact('totalStocks', 'pendingOrders', 'totalOutlets', 'alerts'));
    }

    private function generateAlerts()
    {
        $alerts = [];

        // Fetch orders with 'Pending' status
        $pendingOrders = Order::where('orderStatus', 'Pending')->get();
        foreach ($pendingOrders as $order) {
            $alerts[] = [
                'type' => 'info',
                'message' => "New order #{$order->orderID} is pending review.",
                'code' => 'NEW_ORDER',
                'orderId' => $order->orderID,
            ];
        }

        // Fetch deliveries with all dates NULL
        $incompleteDeliveries = Delivery::whereNull('preparing_date')
            ->whereNull('shipped_date')
            ->whereNull('out_for_delivery_date')
            ->whereNull('delivered_date')
            ->get();

        foreach ($incompleteDeliveries as $delivery) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "Delivery #{$delivery->deliveryID} has no updates yet.",
                'code' => 'DELIVERY_NOT_UPDATED',
                'deliveryId' => $delivery->deliveryID,
            ];
        }

        return $alerts;
    }
}