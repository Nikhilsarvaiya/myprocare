<?php

namespace App\Http\Controllers\User\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessLinkController extends Controller
{
    /**
     * Show the form for business links.
     */
    public function create()
    {
        return view('user.businesses.businesses-links-create');
    }

    /**
     * Show the form for edit business links.
     */
    public function edit(Business $business){
        return view('user.businesses.businesses-links-edit', compact('business'));
    }

    /**
     * Update or Create time slot.
     */
    public function store(Request $request, Business $business)
    {
        $request->validate([
            'website_link' => ['nullable', 'string', 'max:255'],
            'facebook_link' => ['nullable', 'string', 'max:255'],
            'instagram_link' => ['nullable', 'string', 'max:255'],
            'twitter_link' => ['nullable', 'string', 'max:255'],
            'youtube_link' => ['nullable', 'string', 'max:255'],
            'tiktok_link' => ['nullable', 'string', 'max:255'],
            'uber_link' => ['nullable', 'string', 'max:255'],
            'doordash_link' => ['nullable', 'string', 'max:255'],
        ]);

        $business->update([
            'website_link' => $request->website_link,
            'facebook_link' => $request->facebook_link,
            'instagram_link' => $request->instagram_link,
            'twitter_link' => $request->twitter_link,
            'youtube_link' => $request->youtube_link,
            'tiktok_link' => $request->tiktok_link,
            'uber_link' => $request->uber_link,
            'doordash_link' => $request->doordash_link,
        ]);

        if ($request->isMethod('post')){
            $business->update([
                'step_completed' => 3,
            ]);

            return redirect()->route('user.businesses.media.create', $business->id);
        }else{
            // put method
            if ($business->step_completed < 3){
                $business->update([
                    'step_completed' => 3,
                ]);
            }

            return redirect()->route('user.businesses.media.edit', $business->id);
        }
    }
}
