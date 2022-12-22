<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class BookServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        switch($this->method()) {
            case 'POST':
                return [
                    'service_id' => 'required|exists:services,id',
                    'date' => 'required|date',
                ];
            default:break;
        }
        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'service_id.exists' => 'Please make sure that you have chosen a service',
            'date.required' => 'Please pick a service booking date',
            'store_shift_id.exists' => 'Please make sure that you have chosen a service has available shifts'
        ];
    }
}
