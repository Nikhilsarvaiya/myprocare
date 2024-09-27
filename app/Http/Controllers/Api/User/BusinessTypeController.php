<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessTypeResource;
use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $businessTypes = BusinessType::query()
            ->with('media')
            ->when(isset($request->sell_food_beverage), function (Builder $query) use ($request) {
                $query->where('sell_food_beverage', $request->sell_food_beverage);
            })
            ->paginate(10);

        $businessTypes->withQueryString();

        return BusinessTypeResource::collection($businessTypes);
    }

    /**
     * Display the specified resource.
     */
    public function show($businessType)
    {
        $businessType = BusinessType::query()->with('media')->where('id', $businessType)->first();

        return new BusinessTypeResource($businessType);
    }
}
