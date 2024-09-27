<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWithdrawWalletTransactionRequest extends FormRequest
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
            'user_id' => ['required', Rule::exists('users','id')->whereNot('id', \Auth::id())],
            'business_id' => ['required', Rule::exists('businesses','id')->where('user_id', \Auth::id())],
            'business_offer_id' => ['required', 'exists:business_offers,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'user',
            'business_id' => 'business',
            'business_offer_id' => 'business offer',
        ];
    }
}
