<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|string|min:11|max:191',
            'class' => 'required|string',
            'name' => 'required|string|min:2|max:191',
            'address' => 'nullable|string|max:191',
            'phone' => 'nullable|string|min:9|max:191',
            'nationality' => 'nullable|string|max:191',
            'guardian' => 'required|string|max:191',
            'salutation' => 'required|string|max:191',
            'remark' => 'nullable|string|max:191'
        ];
    }

    public function messages()
    {
        return [
            "number.required" => "學號 為必填",
            "number.min" => "學號 至少需11個字元",
            "class.required" => "班級 為必填",
            "name.required" => "姓名 為必填",
            "name.min" => "姓名 至少需2個字元 ",
            "phone.min" => "電話 至少需9個字元",
            "guardian.required" => "關係人 為必填",
            "salutation.required" => "稱謂 為必填",
        ];
    }
}
