<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
            'name.*'=>'required|string',
            'des.*'=>'nullable|string',
            'alt_image.*'=>'nullable|string',
            'title_image.*'=>'nullable|string',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'meta_title.*'  =>'nullable|string',
            'meta_des.*'    =>'nullable|string'
        ];
    }
}
