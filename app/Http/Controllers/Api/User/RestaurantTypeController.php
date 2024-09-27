<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantTypeResource;
use App\Models\RestaurantType;

class RestaurantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurantTypes = RestaurantType::query()->with('media')->paginate(10);

        $restaurantTypes->withQueryString();

        return RestaurantTypeResource::collection($restaurantTypes);
    }

    /**
     * Display the specified resource.
     */
    public function show($restaurantType)
    {
        $restaurantType = RestaurantType::query()->with('media')->where('id', $restaurantType)->first();

        return new RestaurantTypeResource($restaurantType);
    }
}
