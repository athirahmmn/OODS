<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;

class AdminOrderHistoryController extends Controller
{
    public function index()
    {
        // Fetch deliveries where received_date is not null
        $deliveries = Delivery::with(['orders', 'orders.orderDetails.stock', 'user'])
            ->whereNotNull('received_date')
            ->get();
        return view('admin.adminOrderHistory', compact('deliveries'));
    }

    public function adminOrderDetails($deliveryID)
    {
        $delivery = Delivery::with(['orders.orderDetails.stock', 'user'])->findOrFail($deliveryID);
        $orders = $delivery->orders->map(function ($order) {
            return [
                'orderID' => $order->orderID,
                'orderQuantity' => $order->orderQuantity,
                'orderDate' => $order->orderDate,
                'total' => $order->total,
                'orderDetails' => $order->orderDetails->map(function ($detail) {
                    return [
                        'stockName' => $detail->stock->stocksName ?? 'N/A',
                        'quantity' => $detail->quantity,
                    ];
                }),
            ];
        });

        return response()->json([
            'delivery' => $delivery,
            'orders' => $orders,
        ]);
    }

    public function adminDeliveryDetails($deliveryID)
    {
        $delivery = Delivery::with(['orders', 'user'])->findOrFail($deliveryID);

        return response()->json([
            'delivery' => $delivery,
        ]);
    }
}
