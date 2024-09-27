<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdvertisementRequest extends FormRequest
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
            'title' => ['string', 'min:1', 'max:255'],
            'link' => ['nullable', 'required_with:link_title', 'string', 'min:1'],
            'link_title' => ['nullable', 'required_with:link', 'string', 'min:1', 'max:255'],
            'business_id' => ['nullable', 'numeric', 'exists:businesses,id'],
            'image' => ['image', 'max:4096'],
        ];
    }

    public function attributes(): array
    {
        return [
            'business_id' => 'business'
        ];
    }
}
