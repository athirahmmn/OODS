<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Assuming you have an Order model
use Illuminate\Support\Facades\Auth;

class DeliveryStatusController extends Controller
{
    /**
     * Display the delivery status page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supervisor.deliveryStatus');
    }
    
}
