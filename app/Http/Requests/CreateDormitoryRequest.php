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
            'name' => 'required|string|min:2|max:191',
            'housemaster' => 'required|string|min:2|max:191',
            'contact' => 'required|string|min:8|max:191',
            //
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "宿舍名稱 為必填",
            "housemaster.required" => "舍監 為必填",
            "contact.required" => "聯絡資料為必填",
            "contact.min" => "聯絡資料 至少需8個字元",
        ];
    }
}
