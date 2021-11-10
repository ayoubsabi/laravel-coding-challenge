<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric|min:1|max:9999999',
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
            'category_id' => 'integer|exists:App\Models\Category,id',
        ];
    }
}
