<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with realistic demo data.
     */
    public function run(): void
    {
        // 1. Create a user
        User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create warehouses
        $warehouses = Warehouse::factory()->createMany([
            ['name' => 'Mumbai Central',    'location' => 'Mumbai, Maharashtra',    'latitude' => 19.0760, 'longitude' => 72.8777],
            ['name' => 'Delhi North',       'location' => 'New Delhi, Delhi',       'latitude' => 28.7041, 'longitude' => 77.1025],
            ['name' => 'Bangalore Tech Hub','location' => 'Bangalore, Karnataka',   'latitude' => 12.9716, 'longitude' => 77.5946],
        ]);

        // 3. Create products
        $products = Product::factory()->createMany([
            ['name' => 'Wireless Mouse',       'sku' => 'WM-1001', 'base_price' => 29.99],
            ['name' => 'Mechanical Keyboard',   'sku' => 'MK-2002', 'base_price' => 89.99],
            ['name' => 'USB-C Hub',             'sku' => 'UH-3003', 'base_price' => 49.99],
            ['name' => 'Webcam HD 1080p',       'sku' => 'WC-4004', 'base_price' => 59.99],
            ['name' => 'Noise Cancelling Headphones', 'sku' => 'NC-5005', 'base_price' => 199.99],
        ]);

        // 4. Create stock entries 
       
        Stock::create([
            'product_id'   => $products[0]->id,
            'warehouse_id' => $warehouses[0]->id,
            'quantity'     => 5,
            'expires_at'   => now()->addDays(30),
        ]);

        Stock::create([
            'product_id'   => $products[1]->id,
            'warehouse_id' => $warehouses[0]->id,
            'quantity'     => 25,
            'expires_at'   => now()->addDays(45),
        ]);
        Stock::create([
            'product_id'   => $products[1]->id,
            'warehouse_id' => $warehouses[1]->id,
            'quantity'     => 10,
            'expires_at'   => now()->addDays(20),
        ]);

        Stock::create([
            'product_id'   => $products[2]->id,
            'warehouse_id' => $warehouses[1]->id,
            'quantity'     => 120,
            'expires_at'   => now()->addDays(60),
        ]);

        Stock::create([
            'product_id'   => $products[3]->id,
            'warehouse_id' => $warehouses[2]->id,
            'quantity'     => 40,
            'expires_at'   => now()->addDays(3), 
        ]);

        Stock::create([
            'product_id'   => $products[4]->id,
            'warehouse_id' => $warehouses[2]->id,
            'quantity'     => 75,
            'expires_at'   => now()->addDays(90),
        ]);
    }
}
