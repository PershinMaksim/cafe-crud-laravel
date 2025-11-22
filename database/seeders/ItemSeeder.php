<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptop',
            'price' => 999.99,
            'quantity' => 5,
            'is_active' => true
        ]);

        Item::create([
            'name' => 'Mouse',
            'description' => 'Wireless computer mouse',
            'price' => 29.99,
            'quantity' => 20,
            'is_active' => true
        ]);

        Item::create([
            'name' => 'Keyboard',
            'description' => 'Mechanical keyboard',
            'price' => 79.99,
            'quantity' => 0,
            'is_active' => false
        ]);
    }
}