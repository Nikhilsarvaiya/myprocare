<?php

namespace App\Http\Controllers\Admin\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBusinessRequest;
use App\Models\Business;
use App\Models\CoachTime;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'orderKey' => 'in:id,user_id,name,about,sell_food_beverage,step_completed,approved,created_at,updated_at',
            'orderDirection' => 'in:asc,desc'
        ]);

        $businesses = Business::query()
            ->with(['user', 'media','businessType'])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('about', 'like', "%$request->search%");
                });
            })
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $businesses->withQueryString();

        return view('admin.businesses.businesses-index', compact('businesses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business)
    {
        $business = Business::query()
            ->with([
                'user',
                'media',
                'openingHours',
                'businessType',
                'restaurantType',
                'foodType',
                'products',
                'menus'
            ])
            ->where('id', '=', $business->id)
            ->first();

        return view('admin.businesses.businesses-show',compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessRequest $request, Business $business)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        $business->openingHours()->delete();

        if ($business->businessType->sell_food_beverage){
            $business->menus()->delete();
        }else{
            $business->products()->delete();
        }

        $business->delete();

        return redirect()->route('admin.businesses.index');
    }

    public function approve(Business $business)
    {
        $business->approved = true;
        $business->save();

        $businessUser = $business->user;

        if (!$businessUser->hasRole('business')){
            $businessUser->assignRole('business');
        }

        return redirect()->route('admin.businesses.index');
    }
}