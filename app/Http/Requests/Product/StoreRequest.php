<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>['required', 'string', 'max:255'],
            "sku_code"=>['required','unique:products'],
            "description"=>['required', 'string'],
            "imageviewfile"=>['image','mimes:png,gif','max:2048']
        ];
    }
}
