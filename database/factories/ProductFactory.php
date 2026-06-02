<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'        => fake()->unique()->words(3, true),
            'sku'         => strtoupper(fake()->unique()->bothify('??-####')),
            'description' => fake()->sentence(),
            'base_price'  => fake()->randomFloat(2, 5, 500),
        ];
    }
}
