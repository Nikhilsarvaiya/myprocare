<?php

namespace App\Http\Controllers\Api\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessBasicDetailRequest;
use App\Http\Requests\UpdateBusinessBasicDetailRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;

class BusinessBasicDetailController extends Controller
{
    /**
     * Store Business Basic detail and create business.
     */
    public function store(StoreBusinessBasicDetailRequest $request)
    {
        $business = Business::create($request->validated());

        return new BusinessResource($business);
    }

    public function update(UpdateBusinessBasicDetailRequest $request, Business $business)
    {
        $business->update($request->validated());

        return new BusinessResource($business);
    }
}
