<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRoadClosureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->road_closure->user_id === Auth::id() || Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "user_timezone" => ['required'],
            "title" => ['string', 'max:255'],
            "start_time" => ['date', function ($attribute, $value, $fail) {
                // if start_time value changed
                if (Carbon::parse($value) != $this->road_closure->start_time){
                    $userDate = Carbon::parse($value, $this->user_timezone)->addMinutes(1);

                    if ($userDate <= Carbon::now($this->user_timezone)) {
                        $fail("The start time must be a greater than from now.");
                    }
                }
            }],
            "end_time" => ['date', 'after:start_time'],
            "start_latitude" => ['required_with:start_longitude', 'numeric'],
            "start_longitude" => ['required_with:start_latitude', 'numeric'],
            "end_latitude" => ['required_with:end_longitude', 'nullable', 'numeric'],
            "end_longitude" => ['required_with:end_latitude', 'nullable', 'numeric']
        ];
    }
}
