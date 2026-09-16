<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockOutlet;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupervisorStockController extends Controller
{
    // Show all stocks for supervisor filtered by the logged-in outlet (user)
    public function index(Request $request)
    {
        $query = $request->input('query');
        $userID = Auth::id(); // Get the logged-in user's ID

        if ($query) {
            // If there is a search query, perform the search
            $stocks = Stock::where('stocksID', 'LIKE', "%{$query}%")
                ->orWhere('stocksName', 'LIKE', "%{$query}%")
                ->orWhere('price', 'LIKE', "%{$query}%")
                ->with(['outlets' => function($query) use ($userID) {
                    $query->where('userID', $userID); // Filter outlets by the logged-in user's ID
                }])
                ->get();
        } else {
            // Fetch all stocks with outlet data for the current outlet
            $stocks = Stock::with(['outlets' => function($query) use ($userID) {
                $query->where('userID', $userID); // Filter outlets by the logged-in user's ID
            }])->get();
        }

        return view('supervisor.requestPage', compact('stocks', 'query'));
    }

    // Filter stocks by category for supervisor
    public function filter(Request $request)
    {
        $category = $request->input('category');

        if ($category === 'all') {
            $stocks = Stock::with('outlet')->get();
        } else {
            $stocks = Stock::where('category', $category)->with('outlet')->get();
        }

        return view('supervisor.requestPage', compact('stocks'));
    }

    public function updateStocks(Request $request)
    {
        $userID = Auth::id(); // Get the logged-in user's ID

        // Validate the incoming request
        $validatedData = $request->validate([
            'stockID' => 'required|exists:stocks,stocksID',
            'stockQuantity' => 'required|integer|min:1',
        ]);

        try {
            // Check if the StockOutlet exists for the given stockID and userID
            $stockOutlet = StockOutlet::where('stocksID', $validatedData['stockID'])
                                      ->where('userID', $userID)
                                      ->first();

            if ($stockOutlet) {
                // Update the stock quantity if it exists
                $stockOutlet->stocksQuantity = $validatedData['stockQuantity'];
                $stockOutlet->save();
            } else {
                // Create a new StockOutlet entry for this outlet and stock
                Log::info("Creating new StockOutlet for StockID: {$validatedData['stockID']}, UserID: {$userID}");

                StockOutlet::create([
                    'stocksID' => $validatedData['stockID'],
                    'userID' => $userID,
                    'stocksQuantity' => $validatedData['stockQuantity'],
                    'minQuantity' => 1, // Default value, adjust as needed
                ]);
            }

            return response()->json(['message' => 'Stock updated successfully!']);

        } catch (\Exception $e) {
            // Log the exception to laravel.log
            Log::error('Error updating stock: ' . $e->getMessage());
            Log::error($e);

            return response()->json(['error' => 'There was an error updating the stock.'], 500);
        }
    }

    // New method to handle order delivery and update stock quantities
    public function updateStockAfterOrderDelivery($deliveryID)
    {
        try {
            // Retrieve the delivery details
            $delivery = Delivery::findOrFail($deliveryID);

            // Ensure the delivery is marked as 'delivered' and has a received date
            if ($delivery->deliveryStatus === 'delivered' && $delivery->delivered_date) {
                // Retrieve all orders related to this delivery
                $orders = Order::where('deliveryID', $deliveryID)->get();

                foreach ($orders as $order) {
                    // Retrieve order details to get the stocks
                    $orderDetails = OrderDetail::where('orderID', $order->orderID)->get();

                    foreach ($orderDetails as $orderDetail) {
                        // Retrieve the StockOutlet entry for this stock and outlet
                        $stockOutlet = StockOutlet::where('stocksID', $orderDetail->stockID)
                                                  ->where('userID', $order->userID)
                                                  ->first();

                        if ($stockOutlet) {
                            // Increase the stock quantity in StockOutlet by the ordered quantity
                            $stockOutlet->stocksQuantity += $orderDetail->quantity;
                            $stockOutlet->save();
                        } else {
                            // If no entry exists, create a new StockOutlet entry
                            Log::info("Creating new StockOutlet for StockID: {$orderDetail->stockID}, UserID: {$order->userID}");

                            StockOutlet::create([
                                'stocksID' => $orderDetail->stockID,
                                'userID' => $order->userID,
                                'stocksQuantity' => $orderDetail->quantity,
                                'minQuantity' => 1, // Adjust as needed
                            ]);
                        }
                    }
                }

                return response()->json(['message' => 'Stock quantities updated successfully after delivery!']);
            } else {
                return response()->json(['error' => 'The delivery is not completed or has no delivered date.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error updating stock after order delivery: ' . $e->getMessage());
            Log::error($e);
            return response()->json(['error' => 'Error processing the delivery.'], 500);
        }
    }
}
