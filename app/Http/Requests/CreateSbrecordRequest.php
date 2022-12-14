<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSbrecordRequest extends FormRequest
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
            'school_year' => 'required|numeric|min:3|max:191',
        ];
    }

    public function messages()
    {
        return [
            "school_year.required" => "學年 為必填",
            "school_year.numeric" => "學年 需為數字",
            "school_year.min" => "學年 至少需3個字元",
        ];
    }
}
