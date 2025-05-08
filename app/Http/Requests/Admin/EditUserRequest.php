<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
           'first_name'=>'required|string|max:255',
           'last_name'=>'required|string|max:255',
           'email'=>'required|email',
           'avatar'=>'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
           'user_type'       => 'nullable|in:admin,cashier,user,data_entry',
            'password' => [
                'nullable',
                'string',
                'min:9',
                'max:12',
                'confirmed',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{9,12}$/',
            ],
        ];
    }










}
