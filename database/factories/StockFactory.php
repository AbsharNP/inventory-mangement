<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stock>
 */
class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        return [
            'product_id'   => Product::factory(),
            'warehouse_id' => Warehouse::factory(),
            'quantity'     => fake()->numberBetween(1, 200),
            'expires_at'   => fake()->optional(0.5)->dateTimeBetween('+1 day', '+60 days'),
        ];
    }

    /**
     * Set stock as near-expiring (within 7 days).
     */
    public function nearExpiring(): static
    {
        return $this->state(fn () => [
            'expires_at' => fake()->dateTimeBetween('+1 day', '+6 days'),
        ]);
    }

    /**
     * Set a low quantity (for scarcity pricing).
     */
    public function lowStock(): static
    {
        return $this->state(fn () => [
            'quantity' => fake()->numberBetween(1, 5),
        ]);
    }
}
