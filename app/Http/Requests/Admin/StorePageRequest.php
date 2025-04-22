<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'alt_image.*'=>'nullable|string|max:255',
            'title_image.*'=>'nullable|string|max:255',
            'meta_des.*'=>'nullable|string|max:10000',
            'meta_title.*'=>'nullable|string|max:10000',
            'slug.*'=>'required|string|max:255',
            'des.*'=>'nullable|string|max:65000',
            'image'=>'nullable|image|mimes:png,jpg,webp'
        ];
    }
}
