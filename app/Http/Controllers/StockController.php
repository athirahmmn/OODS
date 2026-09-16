<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockOutlet;
use App\Models\StockWarehouse;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    // Show form for managing stocks (Admin)
    public function manageStock()
    {
        $stocks = Stock::with('warehouse')->get(); // Fetch all stocks with warehouse data
        return view('admin.manageStock', compact('stocks'));
    }

    // Store a newly created stock in storage
    public function store(Request $request)
    {
        try {
            Log::info('Storing new stock...');
            $request->validate([
                'stocksName' => 'required|max:200',
                'price' => 'required|numeric',
                'category' => 'required|max:50',
                'stockImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'warehouseQuantity' => 'required|integer',
            ]);

            $data = $request->except('warehouseQuantity');

            if ($request->hasFile('stockImage')) {
                $imageName = time().'.'.$request->stockImage->extension();
                $request->stockImage->move(public_path('images/stocks'), $imageName);
                $data['image'] = 'images/stocks/'.$imageName;
            }

            $stock = Stock::create($data);
            StockWarehouse::create([
                'stocksID' => $stock->stocksID,
                'stocksQuantity' => $request->input('warehouseQuantity'),
            ]);
            StockOutlet::create([
                'stocksID' => $stock->stocksID,
                'stocksQuantity' => 0,
                'minQuantity' => 0,
            ]);

            return redirect()->route('admin.manageStock')->with('success', 'Stock created successfully');
        } catch (\Exception $e) {
            Log::error('Error adding stock: '.$e->getMessage());
            return redirect()->back()->with('error', 'There was an error adding the stock');
        }
    }

    // Update the specified stock in storage
    public function update(Request $request, $id)
    {
        try {
            Log::info('Updating stock ID: '.$id);
            $request->validate([
                'stocksName' => 'required|string|max:200',
                'price' => 'required|numeric',
                'category' => 'required|max:50',
                'stockImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'warehouseQuantity' => 'required|integer',
            ]);

            $stock = Stock::findOrFail($id);

            $data = $request->only(['stocksName', 'price', 'category']);

            if ($request->hasFile('stockImage')) {
                $imageName = time().'.'.$request->stockImage->extension();
                $request->stockImage->move(public_path('images/stocks'), $imageName);
                $data['image'] = 'images/stocks/'.$imageName;
            }

            $stock->update($data);
            StockWarehouse::updateOrCreate(
                ['stocksID' => $stock->stocksID],
                ['stocksQuantity' => $request->input('warehouseQuantity')]
            );

            return response()->json(['message' => 'Stock updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error editing stock ID '.$id.': '.$e->getMessage());
            return response()->json(['message' => 'There was an error editing the stock'], 500);
        }
    }

    // Remove the specified stock from storage
    public function destroy($id)
    {
        try {
            Log::info('Deleting stock ID: '.$id);
            $stock = Stock::findOrFail($id);
            $stock->delete();

            return response()->json(['message' => 'Stock deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting stock ID '.$id.': '.$e->getMessage());
            return response()->json(['message' => 'There was an error deleting the stock'], 500);
        }
    }
}
