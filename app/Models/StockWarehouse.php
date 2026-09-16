<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockWarehouse extends Model
{
    protected $table = 'stocksWarehouse'; // Ensure this matches your table name
    protected $primaryKey = 'stocksID'; // Set your primary key column
    public $incrementing = false; // Since this is a foreign key, it shouldn't auto-increment

    protected $fillable = [
        'stocksID',
        'stocksQuantity',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stocksID', 'stocksID');
    }
}
