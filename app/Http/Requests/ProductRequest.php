<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'PUT':
            case 'PATCH':
                $product = $this->route()->product;
                return [
                    'name:en' => 'required|max:100',
                    'sku' => 'nullable|unique:products,sku,' . $product->id,
                    'price' => 'required_without:variant_options',
                    'category' => 'required',
                    'featured_image' => 'image',

                ];
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name:en' => 'required|max:100',
                    'sku' => 'nullable|unique:products,sku',
                    'price' => 'required_without:variant_options',
                    'featured_image' => 'image',
                    'category' => 'required'
                ];
            default:
                break;
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
            'sku.required' => 'SKU is required!',
            'images.required' => 'Product picture is required',
            'price.required' => 'Price is required!',
        ];
    }
}
