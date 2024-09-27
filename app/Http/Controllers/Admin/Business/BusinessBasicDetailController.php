<?php

namespace App\Http\Controllers\Admin\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessBasicDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessTypes = BusinessType::all();

        return view('admin.businesses.businesses-basic-details-create', compact('businessTypes'));
    }

    /**
     * Store step 1 data.
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_user_email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'business_type' => ['required', 'exists:business_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ],[],[
            'latitude' => 'location',
            'longitude' => 'location',
        ]);

        $user = User::query()->where('email', $request->business_user_email)->first();

        $business = Business::create([
            'user_id' => $user->id,
            'business_type_id' => $request->business_type,
            'name' => $request->name,
            'about' => $request->about,
            'address' => $request->address,
            'phone' => $request->phone,
            'step_completed' => 1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.businesses.opening_hours.create', $business->id);
    }

    public function edit(Business $business){
        $businessTypes = BusinessType::all();

        return view('admin.businesses.businesses-basic-details-edit', compact('business','businessTypes'));
    }

    public function update(Request $request, Business $business){
        $request->validate([
            'business_type' => ['required', 'exists:business_types,id'],
            'name' => ['string', 'max:255'],
            'about' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'phone' => ['regex:/^([0-9\s\-\+\(\)]*)$/'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ],[],[
            'latitude' => 'location',
            'longitude' => 'location',
        ]);

        $business->update([
            'business_type_id' => $request->business_type,
            'name' => $request->name,
            'about' => $request->about,
            'address' => $request->address,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.businesses.opening_hours.edit', $business->id);
    }
}
