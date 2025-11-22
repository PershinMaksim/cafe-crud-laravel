<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    public function run(): void
    {
        Dish::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptop',
            'price' => 999.99,
            'quantity' => 5,
            'is_active' => true
        ]);

        Dish::create([
            'name' => 'Mouse',
            'description' => 'Wireless computer mouse',
            'price' => 29.99,
            'quantity' => 20,
            'is_active' => true
        ]);

        Dish::create([
            'name' => 'Keyboard',
            'description' => 'Mechanical keyboard',
            'price' => 79.99,
            'quantity' => 0,
            'is_active' => false
        ]);
    }
}