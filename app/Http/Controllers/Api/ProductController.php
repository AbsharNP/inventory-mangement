<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\DynamicPricingService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private DynamicPricingService $pricingService,
    ) {}

    /**
     * GET /api/products
     *
     * List all products with dynamically calculated prices.
     */
    public function index(): JsonResponse
    {
        $products = Product::with('stocks')->get();

        $data = $products->map(function (Product $product) {
            $pricing = $this->pricingService->calculate($product);

            return [
                'id'          => $product->id,
                'name'        => $product->name,
                'sku'         => $product->sku,
                'description' => $product->description,
                'pricing'     => $pricing,
                'created_at'  => $product->created_at,
                'updated_at'  => $product->updated_at,
            ];
        });

        return response()->json([
            'message'  => 'Products retrieved successfully.',
            'count'    => $data->count(),
            'products' => $data,
        ]);
    }
}
