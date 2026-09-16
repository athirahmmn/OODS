<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'userID' => Str::uuid(),
            'userName' => $this->faker->name,
            'phoneNumber' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'outletAddress' => $this->faker->address,
            'role' => 'user', // or any other default role
            'remember_token' => Str::random(10),
        ];
    }
}
