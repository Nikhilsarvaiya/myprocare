<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use App\Models\Centers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreCentersRequest extends FormRequest
{
    /**
     * Determine if the Centers is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
