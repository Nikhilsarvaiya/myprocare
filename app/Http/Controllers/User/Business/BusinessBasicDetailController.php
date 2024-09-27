<?php

namespace App\Http\Controllers\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessBasicDetailRequest;
use App\Http\Requests\UpdateBusinessBasicDetailRequest;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessBasicDetailController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessTypes = BusinessType::all();

        return view('user.businesses.businesses-basic-details-create', compact('businessTypes'));
    }

    /**
     * Store step 1 data.
     */
    public function store(StoreBusinessBasicDetailRequest $request)
    {
        $business = Business::create($request->validated());

        return redirect()->route('user.businesses.opening_hours.create', $business->id);
    }

    public function edit(Business $business){
        $businessTypes = BusinessType::all();

        return view('user.businesses.businesses-basic-details-edit', compact('business','businessTypes'));
    }

    public function update(UpdateBusinessBasicDetailRequest $request, Business $business){
        $business->update($request->validated());

        return redirect()->route('user.businesses.opening_hours.edit', $business->id);
    }
}
