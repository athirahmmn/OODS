<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run()
    {
        DB::table('stocks')->insert([
            [
                'stocksName' => 'Cocoa Powder',
                'price' => 89.00,
                'category' => 'powder',
                'image' => 'images/stocks/cocoa-powder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Matcha Powder',
                'price' => 89.00,
                'category' => 'powder',
                'image' => 'images/stocks/matcha-powder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Lotus Biscoff Spread',
                'price' => 137.00,
                'category' => 'topping',
                'image' => 'images/stocks/lotus-biscoff-spread.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Honey',
                'price' => 112.00,
                'category' => 'sweetener',
                'image' => 'images/stocks/honey.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Fresh Milk',
                'price' => 98.00,
                'category' => 'dairy',
                'image' => 'images/stocks/fresh-milk.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Brown Sugar',
                'price' => 155.00,
                'category' => 'sweetener',
                'image' => 'images/stocks/brown-sugar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Red Velvet Powder',
                'price' => 89.00,
                'category' => 'powder',
                'image' => 'images/stocks/red-velvet-powder.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Tapioca Pearl',
                'price' => 87.00,
                'category' => 'topping',
                'image' => 'images/stocks/tapioca-pearl.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Vanilla Syrup',
                'price' => 119.00,
                'category' => 'syrup',
                'image' => 'images/stocks/vanilla-syrup.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Oat Milk',
                'price' => 109.00,
                'category' => 'dairy',
                'image' => 'images/stocks/oat-milk.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Strawberry Purees',
                'price' => 88.00,
                'category' => 'topping',
                'image' => 'images/stocks/strawberry-purees.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Caramel Syrup',
                'price' => 99.00,
                'category' => 'syrup',
                'image' => 'images/stocks/caramel-syrup.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Sweetened Creamer',
                'price' => 108.00,
                'category' => 'sweetener',
                'image' => 'images/stocks/sweetened-creamer.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Whipping Cream',
                'price' => 115.00,
                'category' => 'dairy',
                'image' => 'images/stocks/whipping-cream.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'stocksName' => 'Hazelnut Syrup',
                'price' => 109.00,
                'category' => 'syrup',
                'image' => 'images/stocks/hazelnut-syrup.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

