<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';
    protected $primaryKey = 'deliveryID';
    protected $fillable = [
        'userID',
        'deliveryStatus',
        'preparing_date',
        'shipped_date',
        'out_for_delivery_date',
        'delivered_date',
        'runnerPhoneNumber',
        'image',
    ];

    protected $dates = [
        'preparing_date',
        'shipped_date',
        'out_for_delivery_date',
        'delivered_date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'deliveryID', 'deliveryID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($delivery) {
            $dates = [
                'preparing_date' => $delivery->preparing_date,
                'shipped_date' => $delivery->shipped_date,
                'out_for_delivery_date' => $delivery->out_for_delivery_date,
                'delivered_date' => $delivery->delivered_date,
            ];

            // Enforce date sequence
            $sequence = ['preparing_date', 'shipped_date', 'out_for_delivery_date', 'delivered_date'];
            foreach ($sequence as $index => $current) {
                $next = $sequence[$index + 1] ?? null;
                if ($next && $dates[$current] && $dates[$next] && $dates[$current] > $dates[$next]) {
                    throw new \Exception(ucfirst(str_replace('_', ' ', $next)) . " cannot be earlier than " . ucfirst(str_replace('_', ' ', $current)));
                }
            }
        });
    }
}