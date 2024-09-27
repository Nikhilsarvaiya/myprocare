<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'website_link' => ['nullable', 'string', 'max:255'],
            'facebook_link' => ['nullable', 'string', 'max:255'],
            'instagram_link' => ['nullable', 'string', 'max:255'],
            'twitter_link' => ['nullable', 'string', 'max:255'],
            'youtube_link' => ['nullable', 'string', 'max:255'],
            'tiktok_link' => ['nullable', 'string', 'max:255'],
            'uber_link' => ['nullable', 'string', 'max:255'],
            'doordash_link' => ['nullable', 'string', 'max:255'],
            'restaurant_type' => ['exists:restaurant_types,id'],
            'food_type' => ['exists:food_types,id'],
        ];
    }
}
