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
            'number' => 'required|string|min:11|max:191',
            'class' => 'required|string|min:2|max:191',
            'name' => 'required|string|min:2|max:191',
            'address' => 'nullable|string|min:2|max:191',
            'phone' => 'nullable|string|min:8|max:191', //市話8碼 手機10碼
            'nationality' => 'nullable|string|min:2|max:191',
            'guardian' => 'required|string|min:2|max:191',
            'salutation' => 'required|string|min:2|max:191',
            'remark' => 'nullable|string|min:0|max:191'
            //
        ];
    }

    public function messages()
    {
        return [
            "number.required" => "學號 為必填",
            "number.min" => "球員名稱 至少需11個字元",
            "class.required" => "班級 為必填",
            "name.required" => "姓名 為必填",
            "phone.min" => "電話 至少需8個字元",
            "guardian.required" => "關係人 為必填",
            "salutation.required" => "稱謂 為必填",
        ];
    }
}
