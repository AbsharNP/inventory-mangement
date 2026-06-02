<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Services\DynamicPricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicPricingServiceTest extends TestCase
{
    use RefreshDatabase;

    private DynamicPricingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DynamicPricingService();
    }

    /*
    |--------------------------------------------------------------------------
    | Stock-Level Pricing Tests
    |--------------------------------------------------------------------------
    */

    public function test_scarcity_premium_when_stock_below_10(): void
    {
        $product   = Product::factory()->create(['base_price' => 100.00]);
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 5,
            'expires_at'   => now()->addDays(30),
        ]);

        $result = $this->service->calculate($product);

        $this->assertEquals(130.00, $result['adjusted_price']);  // +30%
        $this->assertEquals('scarcity_premium_30', $result['pricing_rule']);
        $this->assertEquals(5, $result['total_stock']);
    }

    public function test_moderate_supply_markup_when_stock_10_to_50(): void
    {
        $product   = Product::factory()->create(['base_price' => 100.00]);
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 30,
            'expires_at'   => now()->addDays(30),
        ]);

        $result = $this->service->calculate($product);

        $this->assertEquals(110.00, $result['adjusted_price']);  // +10%
        $this->assertEquals('moderate_supply_10', $result['pricing_rule']);
    }

    public function test_normal_pricing_when_stock_51_to_100(): void
    {
        $product   = Product::factory()->create(['base_price' => 100.00]);
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 75,
            'expires_at'   => now()->addDays(30),
        ]);

        $result = $this->service->calculate($product);

        $this->assertEquals(100.00, $result['adjusted_price']);  // no change
        $this->assertEquals('normal_pricing', $result['pricing_rule']);
    }

    public function test_overstock_discount_when_stock_above_100(): void
    {
        $product   = Product::factory()->create(['base_price' => 100.00]);
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 150,
            'expires_at'   => now()->addDays(30),
        ]);

        $result = $this->service->calculate($product);

        $this->assertEquals(80.00, $result['adjusted_price']);  // -20%
        $this->assertEquals('overstock_discount_20', $result['pricing_rule']);
    }

    /*
    |--------------------------------------------------------------------------
    | Expiration-Based Pricing Tests
    |--------------------------------------------------------------------------
    */

    public function test_expiring_stock_gets_additional_discount(): void
    {
        $product   = Product::factory()->create(['base_price' => 100.00]);
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 30,
            'expires_at'   => now()->addDays(3), // Expiring within 7 days
        ]);

        $result = $this->service->calculate($product);

        $this->assertEquals(110.00, $result['adjusted_price']);  // +10% base
        $this->assertEquals(82.50, $result['expiring_price']);   // 110 * 0.75
        $this->assertEquals(30, $result['expiring_units']);
    }

    public function test_no_expiring_price_when_stock_not_near_expiry(): void
    {
        $product   = Product::factory()->create(['base_price' => 100.00]);
        $warehouse = Warehouse::factory()->create();

        Stock::factory()->create([
            'product_id'   => $product->id,
            'warehouse_id' => $warehouse->id,
            'quantity'     => 30,
            'expires_at'   => now()->addDays(30), // Far from expiry
        ]);

        $result = $this->service->calculate($product);

        $this->assertNull($result['expiring_price']);
        $this->assertEquals(0, $result['expiring_units']);
    }

    public function test_zero_stock_gets_scarcity_premium(): void
    {
        $product = Product::factory()->create(['base_price' => 50.00]);

        $result = $this->service->calculate($product);

        $this->assertEquals(65.00, $result['adjusted_price']);  // +30%
        $this->assertEquals(0, $result['total_stock']);
    }

    /*
    |--------------------------------------------------------------------------
    | Unit Method Tests
    |--------------------------------------------------------------------------
    */

    public function test_apply_stock_multiplier_directly(): void
    {
        $this->assertEquals(130.00, $this->service->applyStockMultiplier(100, 5));
        $this->assertEquals(110.00, $this->service->applyStockMultiplier(100, 25));
        $this->assertEquals(100.00, $this->service->applyStockMultiplier(100, 75));
        $this->assertEquals(80.00, $this->service->applyStockMultiplier(100, 150));
    }
}
