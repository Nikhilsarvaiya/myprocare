<?php

namespace App\Http\Controllers\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Business;
use App\Models\Product;
use App\Services\BusinessProductService;
use Illuminate\Http\Request;

class BusinessProductController extends Controller
{
    public function __construct(private readonly BusinessProductService $businessProductService)
    {
    }

    public function createIndex(Business $business)
    {
        $products = $this->businessProductService->getProducts($business->id);

        return view('user.businesses.businesses-products-create-index', compact('products'));
    }

    public function editIndex(Business $business)
    {
        $products = $this->businessProductService->getProducts($business->id);

        return view('user.businesses.businesses-products-edit-index', compact('products'));
    }

    public function store(StoreProductRequest $request, Business $business)
    {
        $this->businessProductService->storeProduct($business, $request->validated());

        if ($request->isMethod('post')) {
            return redirect()->route('user.businesses.products.create.index', $business->id);
        } else {
            // put method
            return redirect()->route('user.businesses.products.edit.index', $business->id);
        }
    }

    public function edit(Request $request, $businessId, Product $product)
    {
        return view('user.businesses.businesses-products-edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, $businessId, Product $product)
    {
        $request->validate([
            'redirect' => 'required|string|in:edit,create'
        ]);

        $this->businessProductService->updateProduct($product, $request->validated());

        if ($request->redirect === "edit") {
            return redirect()->route('user.businesses.products.edit.index', $businessId);
        } else {
            return redirect()->route('user.businesses.products.create.index', $businessId);
        }
    }

    public function destroy(Request $request, $businessId, Product $product)
    {
        $this->businessProductService->destroyProduct($product);

        if ($request->redirect_route === "edit") {
            return redirect()->route('user.businesses.products.edit.index', $businessId);
        } else {
            return redirect()->route('user.businesses.products.create.index', $businessId);
        }
    }
}
