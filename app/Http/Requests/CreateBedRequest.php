<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBedRequest extends FormRequest
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
            'bedcode' => 'required|string|min:5|max:191',
            //
        ];
    }

    public function messages()
    {
        return [
            "bedcode.required" => "床位代碼 為必填",
            "bedcode.min" => "床位代碼 至少需5個字元",
        ];
    }
}
