<?php

namespace App\Http\Requests\Admin;

use App\Trait\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'avatar'=>'nullable|image',
            // 'email'=>'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0-9]{10,15}$/',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        // Use the custom response structure for validation errors
      
          return  $this->res(false, 'Validation errors', 422, ['errors' => $validator->errors()]);
       
    }



}
