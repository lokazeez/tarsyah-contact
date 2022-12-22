<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            case 'GET':

            case 'PUT':
            case 'PATCH':
                return [
                        'name:en' => 'required|max:100',
                        'sort_order' => 'required'
                    ];
            case 'DELETE':
                 return [];
            case 'POST':
                return [
                    'name:en' => 'required|max:100',
                    'sort_order' => 'required',
                    'image' => 'required'
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
            'name:en.required' => 'Name in English is required!',
            'image.required'  => 'Image is required!',
            'sort_order.required'  => 'Sort Order is required!'
        ];
    }

}
