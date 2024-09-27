<?php

namespace App\Http\Controllers\User\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessMediaController extends Controller
{
    /**
     * Show the form for business image and banner.
     */
    public function create()
    {
        return view('user.businesses.businesses-media-create');
    }

    /**
     * Show the form for business image and banner.
     */
    public function store(Request $request, Business $business)
    {
        $request->validate([
            'profile' => ['required', 'image', 'max:2048'],
            'banner' => ['required', 'mimetypes:image/*,video/*'],
        ], [
            'mimetypes' => 'The :attribute field must be a image or video.'
        ]);

        $business->addMediaFromRequest('profile')->toMediaCollection('profile');

        $business->addMediaFromRequest('banner')->toMediaCollection('banner');

        $business->step_completed = 4;
        $business->save();

        if ($business->businessType->sell_food_beverage === 1){
            return redirect()->route('user.businesses.restaurant_type.create', $business->id);
        }

        return redirect()->route('user.businesses.products.create.index', $business->id);
    }

    public function edit($businessId)
    {
        $business = Business::query()
            ->with('media')
            ->where('id', $businessId)
            ->first();

        return view('user.businesses.businesses-media-edit', compact('business'));
    }

    public function update(Request $request, Business $business){

        if ($request->file('profile')){
            $request->validate([
                'profile' => ['required', 'image', 'max:2048'],
            ], [
                'mimetypes' => 'The :attribute field must be a image or video.'
            ]);

            $business->clearMediaCollection('profile');

            $business->addMediaFromRequest('profile')->toMediaCollection('profile');
        }

        if ($request->file('banner')){
            $request->validate([
                'banner' => ['required', 'mimetypes:image/*,video/*'],
            ], [
                'mimetypes' => 'The :attribute field must be a image or video.'
            ]);

            $business->clearMediaCollection('banner');

            $business->addMediaFromRequest('banner')->toMediaCollection('banner');
        }

        if ($business->step_completed < 4){
            $business->update([
                'step_completed' => 4,
            ]);
        }

        if ($business->businessType->sell_food_beverage == 1){
            return redirect()->route('user.businesses.restaurant_type.edit', $business->id);
        }

        return redirect()->route('user.businesses.products.edit.index', $business->id);
    }
}
