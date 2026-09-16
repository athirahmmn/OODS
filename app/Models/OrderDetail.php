<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orderdetails'; // Ensure this matches the table name

    protected $fillable = [
        'orderID',
        'stockID',
        'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stocksID', 'stocksID');
    }
}