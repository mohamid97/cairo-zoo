<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'slug.*'=>'required|string|max:255',
            'type'=>'nullable|in:0,1',
            'parent_id'=>'nullable|integer|exists:categories,id',
            'des.*' => 'nullable|string|max:65535',
            'small_des.*'=>'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'meta_title.*'=>'nullable|max:65535',
            'meta_des.*'=>'nullable|max:65535',
            'alt_image.*'=>'nullable|string|max:255',
            'title_image.*'=>'nullable|string|max:255',

        ];
    }
}
