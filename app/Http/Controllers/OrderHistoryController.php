<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Delivery;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $userID = Auth::id();
        $deliveries = Delivery::where('userID', $userID)
                            ->whereNotNull('received_date')
                            ->with(['orders', 'orders.orderDetails.stock'])
                            ->get();

        return view('supervisor.orderHistory', compact('deliveries'));
    }

    public function orderDetails($deliveryID)
    {
        $delivery = Delivery::with(['orders.orderDetails.stock'])->findOrFail($deliveryID);
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

    public function deliveryDetails($deliveryID)
    {
        $delivery = Delivery::with('orders')->findOrFail($deliveryID);

        return response()->json([
            'delivery' => $delivery,
        ]);
    }
}
