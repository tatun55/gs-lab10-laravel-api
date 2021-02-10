<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "zip_code" => "required|digits:7",
            "pref" => "required|in:" . implode(',', config("pref")),
            "city" => "required|string|max:100",
            "street" => "required|string|max:100"
        ];
    }
}
