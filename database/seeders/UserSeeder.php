<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'userName' => 'kajangHQ',
                'phoneNumber' => '0163049343',
                'email' => 'smoothieflava@gmail.com',
                'password' => Hash::make('kajang'),
                'outletAddress' => '3, Jalan Seksyen 3/6, Taman Kajang Utama, Kajang, Malaysia, 43000',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'userName' => 'kuantanOutlet',
                'phoneNumber' => '01158702547',
                'email' => 'smooteatamantas@gmail.com',
                'password' => Hash::make('kuantan'),
                'outletAddress' => 'Lorong Pandan Damai 2/2, Taman Pandan Damai 2, 25150 Kuantan, Pahang, Kuantan, Malaysia, 25150',
                'role' => 'supervisor',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'userName' => 'msuOutlet',
                'phoneNumber' => '0163049343',
                'email' => 'smoothieflava@gmail.com',
                'password' => Hash::make('msu'),
                'outletAddress' => 'Lot No 1, Naik Parking Hospital On the bridge) University Drive, Platters Foodmart, Off, Persiaran Olahraga, Seksyen 13, 40100 Shah Alam, Selangor',
                'role' => 'supervisor',
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
