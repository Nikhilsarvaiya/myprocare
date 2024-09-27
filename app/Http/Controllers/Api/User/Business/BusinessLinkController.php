<?php

namespace App\Http\Controllers\Api\User\Business;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessLinkController extends Controller
{
    /**
     * Update or Create time slot.
     */
    public function store(Request $request, Business $business)
    {
        $validated = $request->validate([
            'website_link' => ['nullable', 'string', 'max:255'],
            'facebook_link' => ['nullable', 'string', 'max:255'],
            'instagram_link' => ['nullable', 'string', 'max:255'],
            'twitter_link' => ['nullable', 'string', 'max:255'],
            'youtube_link' => ['nullable', 'string', 'max:255'],
            'tiktok_link' => ['nullable', 'string', 'max:255'],
            'uber_link' => ['nullable', 'string', 'max:255'],
            'doordash_link' => ['nullable', 'string', 'max:255'],
        ]);

        $business->update($validated);

        if ($request->isMethod('post')){
            $business->update([
                'step_completed' => 3,
            ]);
        }else{
            // put method
            if ($business->step_completed < 3){
                $business->update([
                    'step_completed' => 3,
                ]);
            }
        }

        return new BusinessResource($business);
    }
}
