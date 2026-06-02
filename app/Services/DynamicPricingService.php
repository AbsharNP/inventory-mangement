<?php

namespace App\Services;

use App\Models\Product;

class DynamicPricingService
{
    /**
     * Calculate a product price from stock level and expiration rules.
     *
     * Rules:
     *  - Total stock < 10 gets +30% (scarcity premium)
     *  - Total stock 10-50 gets +10% (moderate supply)
     *  - Total stock 51-100 keeps the base price
     *  - Total stock > 100 gets -20% (overstock discount)
     *  - Stock expiring within 7 days gets -25% on those units
     */
    public function calculate(Product $product): array
    {
        $totalStock = $product->totalStock();
        $basePrice = (float) $product->base_price;
        $adjustedPrice = $this->applyStockMultiplier($basePrice, $totalStock);
        $expiringUnits = $product->stocks()->expiringWithin(7)->sum('quantity');

        $expiringPrice = ($expiringUnits > 0)
            ? round($adjustedPrice * 0.75, 2)
            : null;

        return [
            'base_price' => $basePrice,
            'adjusted_price' => $adjustedPrice,
            'total_stock' => $totalStock,
            'pricing_rule' => $this->getPricingRule($totalStock),
            'expiring_units' => (int) $expiringUnits,
            'expiring_price' => $expiringPrice,
        ];
    }

    public function applyStockMultiplier(float $basePrice, int $totalStock): float
    {
        $multiplier = match (true) {
            $totalStock < 10 => 1.30,
            $totalStock <= 50 => 1.10,
            $totalStock > 100 => 0.80,
            default => 1.00,
        };

        return round($basePrice * $multiplier, 2);
    }

    private function getPricingRule(int $totalStock): string
    {
        return match (true) {
            $totalStock < 10 => 'scarcity_premium_30',
            $totalStock <= 50 => 'moderate_supply_10',
            $totalStock > 100 => 'overstock_discount_20',
            default => 'normal_pricing',
        };
    }
}
