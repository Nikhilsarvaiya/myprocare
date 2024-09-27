<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'description' => ['required', 'string', 'min:1', 'max:255'],
            'link' => ['nullable', 'required_with:link_title', 'string', 'min:1'],
            'link_title' => ['nullable', 'required_with:link', 'string', 'min:1', 'max:255'],
            'image' => ['required', 'image', 'max:4096'],
        ];
    }

    /**
     * Pass extra data before validation.
     * @return array
     */
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'user_id' => \Auth::id()
        ]);
    }
}
