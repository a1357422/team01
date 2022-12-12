<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeaveRequest extends FormRequest
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
            'start' => 'required',
            'end' => 'required',
            'reason' => 'required|string|max:191',
        ];
    }

    public function messages()
    {
        return [
            "start.required" => "外宿日起 為必填",
            "end.required" => "外宿日訖 為必填",
            "reason.required" => "外宿原因 為必填",
            "reason.max" => "外宿原因 至多不超過191個字元",
        ];
    }
}
