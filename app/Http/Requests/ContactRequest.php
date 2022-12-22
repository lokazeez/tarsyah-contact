<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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

                return [
                        'name' => 'required|max:100',
                        'email' => 'required|max:100',
                        'message' => 'required',
                ];
    }
        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
     public function messages(): array
     {
        return [
            'name.required' => 'Name is required!',
            'email.required' => 'The Email is required!',
            'message.required' => 'Your message is required!',
        ];
    }
}
