<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusinessOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'reward_point' => ['required', 'numeric'],
            'business_id' => ['required', Rule::exists('businesses', 'id')->where('user_id', \Auth::id())],
            'image' => ['required', 'image', 'max:4096']
        ];
    }

    public function attributes(): array
    {
        return [
            'business_id' => 'business'
        ];
    }
}
