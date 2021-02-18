<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:100",
            "desc" => "required|string|max:255",
            "price" => "required|integer|between:100,99999",
            "stock" => "required|integer|between:1,999",
        ];
    }
}
