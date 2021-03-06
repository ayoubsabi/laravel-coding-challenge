<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class IndexFormRequest extends FormRequest
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
            'category_id' => 'integer|exists:App\Models\Category,id',
            'created_at' => 'nullable|date',
            'order_by.name' => 'in:asc,desc',
            'order_by.price' => 'in:asc,desc',
        ];
    }
}
