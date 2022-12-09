<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDormitoryRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:191',
            'housemaster' => 'required|string|min:2|max:191',
            'contact' => 'required|string|min:9|max:191',   //市話9碼 手機10碼
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "宿舍名稱 為必填",
            "name.min" => "宿舍名稱 至少需3個字元",
            "housemaster.required" => "舍監 為必填",
            "housemaster.min" => "舍監 至少需2個字元",
            "contact.required" => "聯絡資料為必填",
            "contact.min" => "聯絡資料 至少需9個字元",
        ];
    }
}
