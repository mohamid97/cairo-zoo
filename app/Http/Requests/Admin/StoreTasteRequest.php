<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTasteRequest extends FormRequest
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
            'name.*'=>'required|string|max:255',
            'slug.*'=>'nullable|string|max:255',
            'des.*'=>'nullable|string|max:6000',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ];


    }
}
