<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoadClosureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge( [
            'user_id' => \Auth::id()
        ]);
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
            "user_id" => ['required'],
            "title" => ['required', 'string', 'max:255'],
            "start_time" => ['required', 'date', function ($attribute, $value, $fail) {
                $userDate = Carbon::parse($value, $this->user_timezone)->addMinutes(1);

                if ($userDate <= Carbon::now($this->user_timezone)) {
                    $fail("The start time must be a greater than from now.");
                }
            }],
            "end_time" => ['required', 'date', 'after:start_time'],
            "start_latitude" => ['required', 'numeric'],
            "start_longitude" => ['required', 'numeric'],
            "end_latitude" => ['required', 'numeric'],
            "end_longitude" => ['required', 'numeric']
        ];
    }
}
