<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockWarehouse;
use App\Models\StockOutlet;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminStockController extends Controller
{
    // Show form for managing stocks (Admin)
    public function manageStock(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            // If there is a search query, perform the search
            $stocks = Stock::where('stocksID', 'LIKE', "%{$query}%")
                ->orWhere('stocksName', 'LIKE', "%{$query}%")
                ->orWhere('price', 'LIKE', "%{$query}%")
                ->with('warehouse')
                ->get();
        } else {
            // Otherwise, fetch all stocks with warehouse data
            $stocks = Stock::with('warehouse')->get();
        }

        return view('admin.manageStock', compact('stocks', 'query'));
    }

    // Store a newly created stock in storage
    public function store(Request $request)
    {
        try {
            Log::info('Storing new stock...');

            // Validate incoming request data
            $request->validate([
                'stocksName' => 'required|max:200',
                'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'], // Two decimal places
                'category' => 'required|max:50',
                'stockImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'warehouseQuantity' => 'required|integer',
            ]);

            // Check if stock name already exists
            $existingStock = Stock::where('stocksName', $request->stocksName)->first();
            if ($existingStock) {
                return response()->json(['error' => 'Stock with this name already exists'], 400);
            }

            // Prepare data for insertion into Stock model
            $data = $request->except('warehouseQuantity');

            if ($request->hasFile('stockImage')) {
                $imageName = time().'.'.$request->stockImage->extension();
                $request->stockImage->move(public_path('images/stocks'), $imageName);
                $data['image'] = 'images/stocks/'.$imageName;
            }

            // Insert into stocks table
            $stock = Stock::create($data);

            // Insert into stockswarehouse table
            StockWarehouse::create([
                'stocksID' => $stock->stocksID,
                'stocksQuantity' => $request->input('warehouseQuantity'),
            ]);

            // Fetch all supervisors
            $supervisors = User::where('role', 'supervisor')->get(); // Assuming 'role' column for user role

            // Insert stock for all supervisors in stocksoutlet with quantity 0 and mark as new
            foreach ($supervisors as $supervisor) {
                StockOutlet::create([
                    'stocksID' => $stock->stocksID,
                    'userID' => $supervisor->userID,
                    'stocksQuantity' => 0, // Set the initial quantity to 0 for supervisors
                    'minQuantity' => 5,
                    // Removed 'isNew' => true
                ]);
            }

            return redirect()->route('admin.manageStock')->with('success', 'Stock created successfully');
        } catch (\Exception $e) {
            Log::error('Error adding stock: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'There was an error adding the stock');
        }
    }

    // Update the specified stock in storage
    public function update(Request $request, $stocksID)
    {
        try {
            // Validate only the fields provided in the request
            $validatedData = $request->validate([
                'stocksName' => 'sometimes|string|max:200',
                'price' => ['sometimes', 'regex:/^\d+(\.\d{1,2})?$/'], // Two decimal places
                'category' => 'sometimes|string|in:syrup,powder,sweetener,dairy,topping',
                'stockImage' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image
                'warehouseQuantity' => 'sometimes|integer|min:1',
            ]);

            // Find the stock entry by stocksID
            $stock = Stock::where('stocksID', $stocksID)->firstOrFail();

            // Check if a new stock name is provided and is different from the current name
            if ($request->filled('stocksName') && $request->stocksName !== $stock->stocksName) {
                $existingStock = Stock::where('stocksName', $request->stocksName)->first();
                if ($existingStock) {
                    return response()->json(['error' => 'Stock with this name already exists'], 400);
                }
            }

            // Handle optional image upload
            if ($request->hasFile('stockImage')) {
                $imageName = time() . '.' . $request->stockImage->extension();
                $request->stockImage->move(public_path('images/stocks'), $imageName);
                $validatedData['image'] = 'images/stocks/' . $imageName;

                // Optionally delete the old image here if needed
            }

            // Update the stock only with provided fields
            $stock->update($validatedData);

            // Update warehouse quantity if provided
            if ($request->has('warehouseQuantity')) {
                StockWarehouse::updateOrCreate(
                    ['stocksID' => $stocksID],
                    ['stocksQuantity' => $request->input('warehouseQuantity')]
                );
            }

            return response()->json(['message' => 'Stock updated successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating stock: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error updating the stock.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Deleting stock ID: '.$id);
            $stock = Stock::findOrFail($id);
            $stock->delete();

            // Deleting related entries from stockswarehouse and stocksoutlet tables
            StockWarehouse::where('stocksID', $id)->delete();
            StockOutlet::where('stocksID', $id)->delete();

            return response()->json(['message' => 'Stock deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting stock ID '.$id.': '.$e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'There was an error deleting the stock'], 500);
        }
    }
}
