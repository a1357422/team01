<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLateRequest extends FormRequest
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
            'sbid' => 'required',
            'start' => 'required|late_dateearlier:end',
            'end' => 'required',
            'reason' => 'required|string|max:191',
            'company' => 'required|string|max:191',
            'contact' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'back_time' => 'required',
            'filename_path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "sbid.required" => "你沒有住宿資料,所以不能申請晚歸",
            "start.required" => "長期晚歸日起 為必填",
            "start.late_dateearlier"=>"長期晚歸日起 必須早於 長期晚歸日訖",
            "end.required" => "長期晚歸日訖 為必填",
            "reason.required" => "長期晚歸原因 為必填",
            "reason.max" => "長期晚歸原因 至多不超過191個字元",
            "company.required" => "單位名稱 為必填",
            "contact.required" => "單位聯絡電話 為必填",
            "address.required" => "單位聯絡地址 為必填",
            "back_time.required" => "預計每日返回宿舍時間 為必填",
            "filename_path.required" => "佐證圖檔路徑 為必填",
        ];
    }
}
