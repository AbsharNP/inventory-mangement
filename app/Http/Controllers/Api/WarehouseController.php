<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Services\DynamicPricingService;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class WarehouseController extends Controller
{
    public function __construct(
        private DynamicPricingService $pricingService,
    ) {}
    /**
     * GET /api/warehouses
     *
     * List all warehouses.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message'    => 'Warehouses retrieved successfully.',
            'warehouses' => Warehouse::all(['id', 'name', 'location']),
        ]);
    }

    
    public function report(int $id): JsonResponse
    {
        $warehouse = Warehouse::with(['stocks.product'])->findOrFail($id);

        // Per-product breakdown
        $products = $warehouse->stocks->map(function ($stock) {

        $pricing = $this->pricingService->calculate($stock->product);

            return [
                'product_id'            => $stock->product->id,
                'product_name'          => $stock->product->name,
                'sku'                   => $stock->product->sku,
                'quantity'              => $stock->quantity,
                'base_price'            => $pricing['base_price'],
                'dynamic_selling_price' => $pricing['adjusted_price'],
                'expires_at'            => $stock->expires_at?->toDateTimeString(),
            ];
        });

        // Near-expiring items (within 7 days)
        $nearExpiring = $warehouse->stocks
            ->filter(fn ($stock) => $stock->expires_at && $stock->expires_at->between(now(), now()->addDays(7)))
            ->map(fn ($stock) => [
                'product_id'   => $stock->product->id,
                'product_name' => $stock->product->name,
                'sku'          => $stock->product->sku,
                'quantity'     => $stock->quantity,
                'expires_at'   => $stock->expires_at->toDateTimeString(),
                'days_left'    => (int) now()->diffInDays($stock->expires_at, false),
            ])
            ->values();
        $pdf = Pdf::loadView('reports.warehouse', [
    'warehouse' => $warehouse,
    'products' => $products,
    'nearExpiring' => $nearExpiring,
]);

$fileName = 'warehouse_'.$warehouse->id.'_'.time().'.pdf';

Storage::disk('public')->put(
    'reports/'.$fileName,
    $pdf->output()
);

$pdfUrl = asset('storage/reports/'.$fileName);
        return response()->json([
            'message'   => 'Warehouse report generated successfully.',
            'pdf_url' => $pdfUrl,
            'warehouse' => [
                'id'       => $warehouse->id,
                'name'     => $warehouse->name,
                'location' => $warehouse->location,
            ],
            'summary' => [
                'total_products'       => $products->count(),
                'total_quantity'       => $products->sum('quantity'),
                'near_expiring_count'  => $nearExpiring->count(),
            ],
            'products'      => $products,
            'near_expiring' => $nearExpiring,
        ]);
    }
}
