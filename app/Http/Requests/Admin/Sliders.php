<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Sliders extends FormRequest
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
            'image'         =>'required|image|mimes:jpeg,png,jpg,gif',
            'name.*'        =>'nullable|max:255',
            'small_des.*'   =>'nullable|max:255',
            'des.*'         =>'nullable|max:5000',
            'arrange'       =>'nullable|integer',
            'title_image.*' =>'nullable|string|max:255',
            'alt_image.*'   =>'nullable|string|max:255',
            'link'          =>'nullable|string|max:255',
            'video' => 'nullable|file|mimes:mp4,avi,mkv|max:50000',


        ];
    }
}
