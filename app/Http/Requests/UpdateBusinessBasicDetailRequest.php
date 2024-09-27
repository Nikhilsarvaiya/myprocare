<?php

namespace App\Http\Requests;

use App\Services\GoogleMapsService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateBusinessBasicDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (isset($this->latitude) || isset($this->longitude)) {
            return;
        } else {
            $data = (new GoogleMapsService())->getLatLongFromAddress($this->address);

            if (!$data) {
                throw ValidationException::withMessages(['address' => 'invalid address.']);
            }

            $this->merge([
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'business_type_id' => ['exists:business_types,id'],
            'name' => ['string', 'max:255'],
            'about' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'phone' => ['regex:/^([0-9\s\-\+\(\)]*)$/'],
            'latitude' => ['required_with:longitude', 'numeric'],
            'longitude' => ['required_with:latitude', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'business_type_id' => 'business type'
        ];
    }
}
