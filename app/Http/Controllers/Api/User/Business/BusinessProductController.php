<?php

namespace App\Http\Controllers\Api\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Business;
use App\Models\Product;
use App\Services\BusinessProductService;
use Illuminate\Http\Request;

class BusinessProductController extends Controller
{
    public function __construct(private readonly BusinessProductService $businessProductService)
    {
    }

    public function index(Business $business)
    {
        $products = $this->businessProductService->getProducts($business->id);

        return ProductResource::collection($products);
    }

    /**
     * Store data.
     */
    public function store(StoreProductRequest $request, Business $business)
    {
        $product = $this->businessProductService->storeProduct($business, $request->validated());

        $product = $this->businessProductService->getProductById($product->id);

        return new ProductResource($product);
    }

    public function show($businessId, Product $product)
    {
        $product->load('media');

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, $businessId, Product $product)
    {
        $this->businessProductService->updateProduct($product, $request->validated());

        $product = $this->businessProductService->getProductById($product->id);

        return new ProductResource($product);
    }

    /**
     * Delete Menu Item.
     */
    public function destroy(Request $request, $businessId, Product $product)
    {
        $this->businessProductService->destroyProduct($product);

        return response()->noContent();
    }
}
