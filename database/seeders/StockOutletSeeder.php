<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockOutletSeeder extends Seeder
{
    public function run()
    {
        DB::table('stocksOutlet')->insert([
            [
                'stocksID' => 10,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 11,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 12,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 13,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 14,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 15,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 16,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 17,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 18,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 19,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 20,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 21,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 22,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 23,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 24,
                'stocksQuantity' => 14,
                'minQuantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
