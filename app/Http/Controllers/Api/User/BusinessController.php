<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $businesses = Business::query()
            ->with([
                'user',
                'media',
                'openingHours',
                'businessType',
                'businessType.media',
                'restaurantType',
                'restaurantType.media',
                'foodType',
                'foodType.media',
                'products',
                'products.media',
                'menus',
                'menus.media',
            ])
            ->when(isset($request->sell_food_beverage), function ($query) use ($request) {
                $query->whereHas('businessType', function ($query) use ($request) {
                    $query->where('sell_food_beverage', '=', $request->sell_food_beverage);
                });
            })
            ->when(isset($request->business_type_id), function ($query) use ($request) {
                $query->whereHas('businessType', function ($query) use ($request) {
                    $query->where('id', '=', $request->business_type_id);
                });
            })
            ->when(isset($request->restaurant_type_id), function ($query) use ($request) {
                $query->whereHas('restaurantType', function ($query) use ($request) {
                    $query->where('id', '=', $request->restaurant_type_id);
                });
            })
            ->when(isset($request->food_type_id), function ($query) use ($request) {
                $query->whereHas('foodType', function ($query) use ($request) {
                    $query->where('id', '=', $request->food_type_id);
                });
            })
            ->paginate(10);

        $businesses->withQueryString();

        return BusinessResource::collection($businesses);
    }

    public function show($businessId)
    {
        $business = Business::query()
            ->with([
                'user',
                'media',
                'openingHours',
                'businessType',
                'businessType.media',
                'restaurantType',
                'restaurantType.media',
                'foodType',
                'foodType.media',
                'products',
                'products.media',
                'menus',
                'menus.media',
            ])
            ->where('id', '=', $businessId)
            ->first();

        if (!$business) {
            return response()->noContent(ResponseAlias::HTTP_NOT_FOUND);
        }

        return new BusinessResource($business);
    }

    public function allBusiness(Request $request)
    {
        $businesses = Business::query()
            ->with([
                'user',
                'media',
                'openingHours',
                'businessType',
                'businessType.media',
                'restaurantType',
                'restaurantType.media',
                'foodType',
                'foodType.media',
                'products',
                'products.media',
                'menus',
                'menus.media',
            ])
            ->where('name','LIKE','%'.$request->name.'%')
            ->paginate(10);

        $businesses->withQueryString();

        return BusinessResource::collection($businesses);
    }
}
