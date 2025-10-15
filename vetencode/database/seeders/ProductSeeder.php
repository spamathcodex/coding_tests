<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Espresso', 'Latte', 'Cappuccino', 'Mocha', 'Americano'];

        foreach ($names as $name) {
            Product::create([
                'name' => $name,
                'price' => rand(15000, 80000),
                'active' => true
            ]);
        }
    }
}
