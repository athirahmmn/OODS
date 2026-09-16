<?php

// OrderController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = $request->input('cart');

        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // Calculate total and quantity
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['stockPrice'] * $item['quantity'];
        }

        // Count distinct items in the cart
        $distinctItemCount = count($cart);

        // Create new order
        $order = new Order();
        $order->userID = Auth::id();
        $order->orderDate = Carbon::now();
        $order->orderQuantity = $distinctItemCount; // Set to number of distinct items
        $order->orderStatus = 'Pending';
        $order->total = $total;
        $order->save();

        // Save order details
        foreach ($cart as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->orderID = $order->orderID;
            $orderDetail->stocksID = $item['stockID'];
            $orderDetail->quantity = $item['quantity'];
            $orderDetail->save();
        }

        return response()->json(['message' => 'Order placed successfully']);
    }
    public function showOrderDetails($orderID)
    {
        Log::info('Fetching order details for orderID: ' . $orderID);

        $order = Order::with('orderDetails')->find($orderID);

        if (!$order) {
            Log::error('Order not found for orderID: ' . $orderID);
            return response()->json(['message' => 'Order not found'], 404);
        }

        Log::info('Order found: ', ['order' => $order]);

        return view('supervisor.orderDetails', compact('order'))->render();
    }
}
