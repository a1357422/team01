<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRollcallRequest extends FormRequest
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
            'image.*' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            "image.*.mimes" => "檔案必須是jpeg,jpg,png",
        ];
    }
}
