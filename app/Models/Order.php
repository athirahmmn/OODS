<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'orderID';

    // Define the fillable attributes
    protected $fillable = [
        'userID',
        'orderDate',
        'orderQuantity',
        'orderStatus',
        'total',
        'reason',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // Define the relationship with the Delivery model
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'orderID', 'orderID');
    }

    // Define the relationship with the OrderDetail model
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'orderID', 'orderID');
    }

    public function outlet()
    {
        return $this->hasOne(Outlet::class, 'userID', 'userID');
    }
}
