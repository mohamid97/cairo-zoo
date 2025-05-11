<?php

namespace App\Http\Requests\Cashier;

use App\Trait\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderRequest extends FormRequest
{
    use ResponseTrait;

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
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'coupon_code' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
          $this->res(false, 'Validation errors', 422, ['errors' => $validator->errors()])
        );
          
        
    }
}
