<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class BusinessProductService
{
    public function getProducts($businessId): Collection
    {
        return Product::query()
            ->with('media')
            ->where('business_id', $businessId)
            ->latest()
            ->get();
    }

    public function getProductById($id): Product
    {
        return Product::query()
            ->with('media')
            ->find($id);
    }

    public function storeProduct($business, $data)
    {
        $product = $business->products()->create($data);

        if (isset($data['image'])) {
            $product->addMedia($data['image'])->toMediaCollection();
        }

        if ($business->step_completed < 5) {
            $business->update([
                'step_completed' => 5,
            ]);
        }

        return $product;
    }

    public function updateProduct($product, $data): Product
    {
        $product->update($data);

        if (isset($data['image'])) {
            $product->clearMediaCollection();

            $product->addMedia($data['image'])->toMediaCollection();
        }

        return $product;
    }

    public function destroyProduct($product): void
    {
        $product->delete();
    }
}
