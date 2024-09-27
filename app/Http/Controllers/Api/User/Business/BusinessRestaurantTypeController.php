<?php

namespace App\Http\Controllers\Api\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\FoodType;
use App\Models\RestaurantType;
use Illuminate\Http\Request;

class BusinessRestaurantTypeController extends Controller
{
    /**
     * Store Data.
     */
    public function store(Request $request, Business $business)
    {
        $request->validate([
            'restaurant_type' => ['required', 'exists:restaurant_types,id'],
            'food_type' => ['required', 'exists:food_types,id'],
        ]);

        $business->restaurant_type_id = $request->restaurant_type;
        $business->food_type_id = $request->food_type;

        if ($business->step_completed < 5){
            $business->step_completed = 5;
        }

        $business->save();

        return new BusinessResource($business);
    }
}
