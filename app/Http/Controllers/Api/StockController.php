<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    /**
     * POST /api/stock
     *
     * Create or update a stock record for a product in a warehouse.
     * Uses updateOrCreate to handle upsert cleanly.
     */
    public function store(StoreStockRequest $request): JsonResponse
    {
        $stock = Stock::updateOrCreate(
            [
                'product_id'   => $request->product_id,
                'warehouse_id' => $request->warehouse_id,
            ],
            [
                'quantity'   => $request->quantity,
                'expires_at' => $request->expires_at,
            ]
        );

        $stock->load(['product', 'warehouse']);

        $isNew = $stock->wasRecentlyCreated;

        return response()->json([
            'message' => $isNew ? 'Stock created successfully.' : 'Stock updated successfully.',
            'stock'   => [
                'id'           => $stock->id,
                'product'      => $stock->product->only(['id', 'name', 'sku']),
                'warehouse'    => $stock->warehouse->only(['id', 'name', 'location']),
                'quantity'     => $stock->quantity,
                'expires_at'   => $stock->expires_at?->toDateTimeString(),
                'created_at'   => $stock->created_at,
                'updated_at'   => $stock->updated_at,
            ],
        ], $isNew ? 201 : 200);
    }
}
