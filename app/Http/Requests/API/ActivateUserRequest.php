<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ActivateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
                return [
                    'phone_number' => 'required|exists:users,phone_number',
                    'activation_code' => 'required'
                ];
            default:break;
        }
        return [];
    }

    public function messages(): array
    {
        return [
            'phone_number.exists' => 'We could not find any phone number that matches the number you sent',
        ];
    }
}
