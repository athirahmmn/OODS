<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ManageDeliveriesController extends Controller
{
    public function index()
    {
        // Get all deliveries with their associated orders and user info
        $deliveries = Delivery::with(['orders', 'user'])->get();

        return view('admin.arrangeDelivery', compact('deliveries'));
    }

    public function updateDeliveryStatus(Request $request, $deliveryID)
    {
        try {
            $validatedData = $request->validate([
                'deliveryStatus' => 'required|in:Not Updated Yet,Preparing for Delivery,Shipped,Out for Delivery,Delivered',
                'deliveryDate' => 'required|date|after_or_equal:today',
                'runnerPhoneNumber' => 'required_if:deliveryStatus,Shipped|nullable|string|regex:/^(01[0-46-9]-?\d{7,8})$/',
            ]);
    
            $delivery = Delivery::findOrFail($deliveryID);
    
            // Check if the status has already been updated
            if ($this->statusAlreadyUpdated($delivery, $validatedData['deliveryStatus'])) {
                return redirect()->back()->with('error', 'The selected delivery status has already been updated.');
            }
    
            // Check if the update sequence is valid
            if (!$this->isUpdateSequenceValid($delivery, $validatedData['deliveryStatus'])) {
                return redirect()->back()->with('error', 'Cannot skip delivery status. Please follow the correct sequence.');
            }
    
            // Update delivery details
            $delivery->deliveryStatus = $validatedData['deliveryStatus'];
            $delivery->runnerPhoneNumber = $validatedData['runnerPhoneNumber'] ?? $delivery->runnerPhoneNumber;
    
            switch ($validatedData['deliveryStatus']) {
                case 'Preparing for Delivery':
                    $delivery->preparing_date = $delivery->preparing_date ?? $validatedData['deliveryDate'];
                    break;
                case 'Shipped':
                    $delivery->shipped_date = $delivery->shipped_date ?? $validatedData['deliveryDate'];
                    break;
                case 'Out for Delivery':
                    $delivery->out_for_delivery_date = $delivery->out_for_delivery_date ?? $validatedData['deliveryDate'];
                    break;
                case 'Delivered':
                    $delivery->delivered_date = $delivery->delivered_date ?? $validatedData['deliveryDate'];
                    if ($request->hasFile('deliveryImage')) {
                        $path = $request->file('deliveryImage')->store('delivery_images', 'public');
                        $delivery->image = $path;
                    }
                    break;
            }
    
            $delivery->save();
    
            return redirect()->back()->with([
                'success' => 'Delivery status updated successfully to "' . $validatedData['deliveryStatus'] . '".',
                'deliveryID' => $deliveryID,
                'status' => $validatedData['deliveryStatus'],
                'date' => $validatedData['deliveryDate'],
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating delivery status: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Date cannot be earlier than the previous delivery status date.');
        }
    }
    
    /**
     * Validate if the update sequence is followed correctly.
     */
    private function isUpdateSequenceValid($delivery, $newStatus)
    {
        $sequence = [
            'Not Updated Yet' => 0,
            'Preparing for Delivery' => 1,
            'Shipped' => 2,
            'Out for Delivery' => 3,
            'Delivered' => 4,
        ];
    
        $currentStatus = $delivery->deliveryStatus ?? 'Not Updated Yet';
        return $sequence[$newStatus] === $sequence[$currentStatus] + 1;
    }
    
    /**
     * Check if the status has already been updated.
     */
    private function statusAlreadyUpdated($delivery, $status)
    {
        switch ($status) {
            case 'Preparing for Delivery':
                return !is_null($delivery->preparing_date);
            case 'Shipped':
                return !is_null($delivery->shipped_date);
            case 'Out for Delivery':
                return !is_null($delivery->out_for_delivery_date);
            case 'Delivered':
                return !is_null($delivery->delivered_date);
            default:
                return false;
        }
    }
}    