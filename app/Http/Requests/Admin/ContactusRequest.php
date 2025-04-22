<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactusRequest extends FormRequest
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
            //
            'email'=>'nullable|email',
            'des.*'=>'nullable|string',
            'meta_title.*'=>'nullable|string',
            'meta_des.*'=>'nullable|string',
            'title_image.*'=>'nullable|string',
            'alt_image.*'=>'nullable|string',
            'phone1'=>'nullable|string',
            'phone2'=>'nullable|string',
            'phone3'=>'nullable|string',
            'address.*'=>'nullable|string',
            'name.*'=>'required|string',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp'
        ];
    }
}
