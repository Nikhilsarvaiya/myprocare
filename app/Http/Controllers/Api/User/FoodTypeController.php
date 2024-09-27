<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodTypeResource;
use App\Models\FoodType;

class FoodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodTypes = FoodType::query()->with('media')->paginate(10);

        $foodTypes->withQueryString();

        return FoodTypeResource::collection($foodTypes);
    }

    /**
     * Display the specified resource.
     */
    public function show($foodType)
    {
        $foodType = FoodType::query()->with('media')->where('id', $foodType)->first();

        return new FoodTypeResource($foodType);
    }
}
