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
            'des.*' => 'nullable|string|max:65535',
            'meta_title.*'=>'nullable|max:65535',
            'small_des.*'=>'nullable|max:65535',
            'meta_des.*'=>'nullable|max:65535',
            'category_id'=>'nullable|integer|exists:categories,id',
            'taste_id'=>'nullable|integer|exists:tastes,id',
            'brand_id'=>'nullable|integer|exists:brands,id',
            'sales_price' => 'nullable|numeric|min:0',
            'sku'=>'nullable|max:255',
            'video'=>'nullable|url|max:255',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'thumbinal'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'weight' => 'nullable|numeric|min:1',
            'height' => 'nullable|numeric|min:1',
            'width'  => 'nullable|numeric|min:1',
            'length' => 'nullable|numeric|min:1',
            'status' => 'nullable|in:published,pending',
            'related_products.*' => 'nullable|exists:products,id',
            'barcode' => 'required|string|max:255',
        ];



    }



}
