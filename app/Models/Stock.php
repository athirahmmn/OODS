<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks'; // Ensure this matches your table name
    protected $primaryKey = 'stocksID'; // Set your primary key column

    protected $fillable = [
        'stocksName',
        'price',
        'category',
        'image',
    ];

    public function warehouse()
    {
        return $this->hasOne(StockWarehouse::class, 'stocksID', 'stocksID');
    }

    // A Stock can have many outlets (hasMany relationship)
    public function outlets()
    {
        return $this->hasMany(StockOutlet::class, 'stocksID', 'stocksID');
    }
}
