<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code'            => 'required|unique:coupons,code|max:50',
            'type'            => 'required|in:percentage,fixed',
            'discount_value'  => 'required|numeric|min:0.01',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'usage_limit'     => 'nullable|integer|min:1',
            'is_active' => 'nullable|in:on,1,true,0,false,off',

        ];
    }
}
