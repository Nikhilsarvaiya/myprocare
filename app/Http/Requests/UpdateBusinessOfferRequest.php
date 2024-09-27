<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBusinessOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->business_offer->user->id === Auth::id() || Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'reward_point' => ['numeric'],
            'business_id' => [Rule::exists('businesses', 'id')->where('user_id', \Auth::id())],
            'image' => ['image', 'max:4096']
        ];
    }

    public function attributes(): array
    {
        return [
            'business_id' => 'business'
        ];
    }
}
