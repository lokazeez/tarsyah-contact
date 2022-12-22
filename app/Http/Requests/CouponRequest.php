<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        $coupon = $this->route()->coupon;
        switch ($this->method()) {
            case 'GET':
            case 'PUT':
            return [
                'name:en' => 'required|max:100',
                'coupon_value' => 'required',
//                'code' => 'required|max:100|unique:coupons',
                'min_amount' => 'required',

//                'start_date'=>'nullable|date|date_format:Y-m-d|before:end_date,'.$coupon->id,
                'end_date' => 'required|date|date_format:Y-m-d|after:tomorrow,'.$coupon->id
            ];
            case 'PATCH':
            case 'POST':
                return [
                    'name:en' => 'required|max:100',
                    'code' => 'required|max:100|unique:coupons',
                    'coupon_value' => 'required',
                    'min_amount' => 'required',
//                    'start_date'=>'nullable|date|date_format:Y-m-d|before:end_date',
                    'end_date' => 'required|date|date_format:Y-m-d|after:tomorrow'
                ];
            case 'DELETE':
                return [];
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
        ];
    }
}
