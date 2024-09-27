<?php

namespace App\Http\Controllers\BusinessRegister;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasicDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessTypes = BusinessType::all();

        return view('business-register.basic-details-create', compact('businessTypes'));
    }

    /**
     * Store step 1 data.
     */
    public function store(Request $request)
    {
        $request->validate([
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

        $business = Business::create([
            'user_id' => Auth::id(),
            'business_type_id' => $request->business_type,
            'name' => $request->name,
            'about' => $request->about,
            'address' => $request->address,
            'phone' => $request->phone,
            'step_completed' => 1,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('business_register.opening_hours.create');
    }
}
