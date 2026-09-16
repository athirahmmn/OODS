<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutlet extends Model
{
    protected $table = 'stocksOutlet'; // Ensure this matches your table name
    public $incrementing = false; // Since this is a composite key, it shouldn't auto-increment
    public $timestamps = true;

    protected $fillable = [
        'stocksID',
        'userID',
        'stocksQuantity',
        'minQuantity'
    ];

    // Define primaryKey as an array for composite key handling
    protected $primaryKey = ['stocksID', 'userID'];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stocksID', 'stocksID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    // Override the setKeysForSaveQuery method to handle composite primary keys
    protected function setKeysForSaveQuery($query)
    {
        $query->where('stocksID', '=', $this->getAttribute('stocksID'))
              ->where('userID', '=', $this->getAttribute('userID'));

        return $query;
    }
}
