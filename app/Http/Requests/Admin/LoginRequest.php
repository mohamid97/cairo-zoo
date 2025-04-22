<?php

namespace App\Http\Requests\Admin;

use App\Trait\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:6|max:20'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Use the custom response structure for validation errors
      
          return  $this->res(false, 'Validation errors', 422, ['errors' => $validator->errors()]);
       
    }
}
