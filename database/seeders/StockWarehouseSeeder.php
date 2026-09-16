<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockWarehouseSeeder extends Seeder
{
    public function run()
    {
        DB::table('stocksWarehouse')->insert([
            [
                'stocksID' => 10, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 11, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 12, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 13, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 14, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 15, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 16, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 17, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 18, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 19, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 20, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 21, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 22, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 23, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksID' => 24, // Corresponding stocksID from stocks table
                'stocksQuantity' => 75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
