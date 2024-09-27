<?php

namespace App\Http\Controllers\User\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\FoodType;
use App\Models\RestaurantType;
use Illuminate\Http\Request;

class BusinessRestaurantTypeController extends Controller
{
    /**
     * Show the form for business time slot.
     */
    public function create()
    {
        $restaurant_types = RestaurantType::query()->select(['id', 'name'])->get();
        $food_types = FoodType::query()->select(['id', 'name'])->get();

        return view('user.businesses.businesses-restaurant-type-create', compact('restaurant_types', 'food_types'));
    }

    public function edit(Business $business){
        $restaurant_types = RestaurantType::query()->select(['id', 'name'])->get();
        $food_types = FoodType::query()->select(['id', 'name'])->get();

        return view('user.businesses.businesses-restaurant-type-edit', compact('restaurant_types', 'food_types','business'));
    }

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

        if ($request->isMethod('post')){
            return redirect()->route('user.businesses.menus.create.index', $business->id);
        }else{
            // put method
            return redirect()->route('user.businesses.menus.edit.index', $business->id);
        }
    }
}
