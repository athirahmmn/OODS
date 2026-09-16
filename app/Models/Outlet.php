<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $primaryKey = 'outletID';

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}
