<?php

namespace App\Http\Controllers\BusinessRegister;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\OpeningHour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpeningHourController extends Controller
{
    /**
     * Show the form for business time slot.
     */
    public function create()
    {
        $days = Carbon::getDays();

        return view('business-register.opening-hours-create', compact('days'));
    }

    /**
     * Store the business time slot.
     */
    public function store(Request $request, Business $business)
    {
        for ($i = 0; $i < 7; $i++) {
            $openingHours[] = [
                'start_time' => $request->start_time[$i],
                'end_time' => $request->end_time[$i],
                'open' => isset($request->open[$i]) ? 1 : 0,
            ];
        }

        $days = Carbon::getDays();

        foreach ($openingHours as $index => $openingHour) {
            if ($openingHour['open'] === 1) {
                Validator::validate($openingHour, [
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i'
                ], [
                    'start_time.required' => 'Start time required for ' . $days[$index],
                    'end_time.required' => 'End time is required for ' . $days[$index],
                    'start_time.date_format' => 'Invalid start time format for ' . $days[$index],
                    'end_time.date_format' => 'Invalid end time format for ' . $days[$index],
                ]);

                OpeningHour::updateOrCreate(
                    [
                        'business_id' => $business->id,
                        'day' => $index,
                    ],
                    [
                        'start_time' => $request->start_time[$index] ?? null,
                        'end_time' => $request->end_time[$index] ?? null,
                        'open' => $request->open[$index] === "on" ? 1 : 0,
                    ]
                );
            } else {
                OpeningHour::updateOrCreate(
                    [
                        'business_id' => $business->id,
                        'day' => $index,
                    ],
                    [
                        'start_time' => null,
                        'end_time' => null,
                        'open' => 0,
                    ]
                );
            }
        }

        if ($request->isMethod('post')) {
            $business->update([
                'step_completed' => 2,
            ]);

            return redirect()->route('admin.businesses.links.create', $business->id);
        } else {
            // put method
            if ($business->step_completed < 2){
                $business->update([
                    'step_completed' => 2,
                ]);
            }

            return redirect()->route('admin.businesses.links.edit', $business->id);
        }
    }
}