<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\BusinessType;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BusinessType::query()->with('media')->paginate(10);

        $categories->withQueryString();

        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show($category)
    {
        $category = BusinessType::query()->with('media')->where('id', $category)->first();

        return new CategoryResource($category);
    }
}
