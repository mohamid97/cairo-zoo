<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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

        $couponId = $this->route('id');
        return [
            'code'           => 'required|string|unique:coupons,code,' . $couponId,
            'type'           => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:1',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'usage_limit'    => 'required|integer|min:1',
            'is_active' => 'nullable|in:on,1,true,0,false,off',
        ];
    }
}
