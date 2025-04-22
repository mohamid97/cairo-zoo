<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Trait\ResponseTrait;

class SubscribeRequest extends FormRequest
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
            'email' => 'required|email',
        ];
    }


    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(
            $this->res(false, 'Validation errors', 422, ['errors' => $validator->errors()])
        );


    }


}
