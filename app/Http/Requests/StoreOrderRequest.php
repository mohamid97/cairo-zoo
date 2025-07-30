<?php

namespace App\Http\Requests;

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
            'payment_method' => 'required|in:cash,paymob,else',
            'shipment_way' => 'required|string|in:store,delivery',
            'address' => 'required|string|max:60000',
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'phone' => ['required', 'regex:/^01[0-2,5]{1}[0-9]{8}$/'],
            'zone_id'=>'required|integer|exists:shimpment_zones,id',
            'city_id'=>'required|integer|exists:cities,id',
            'points'=>'nullable|integer|min:1|max:10000',
            'location'=>'nullable|max:50000'


        ];
    }


        // Override the failedValidation method to use $this->res()
        protected function failedValidation(Validator $validator)
        {
            throw new HttpResponseException(
              $this->res(false, __('main.validation_failed'), 422, ['errors' => $validator->errors()])
            );


        }
}
