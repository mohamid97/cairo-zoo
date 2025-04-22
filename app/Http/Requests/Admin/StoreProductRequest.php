<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'des.*' => 'required|string|max:65535',
            'meta_title.*'=>'nullable|max:65535',
            'meta_des.*'=>'nullable|max:65535',
            'category'=>'nullable|integer|exists:categories,id',
            'discount'=>'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'sku'=>'nullable|max:255',
            'video'=>'nullable|url'
        ];

    }
}
