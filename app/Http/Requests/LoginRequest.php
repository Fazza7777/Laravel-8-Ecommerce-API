<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone'=>'required|digits_between:7,11',
            'password'=>'required|min:6'
        ];
    }
    public function messages()
    {
        return [
           'phone.required'=>'ဖုန်းနံပါတ်ထည့်ရန်လိုအပ်ပါသည်။',
           'phone.digits_between'=>'ဖုန်းနံပါတ်သည်အနည်းဆုံး ၇ လုံး အများဆုံး ၁၁ လုံးဖြစ်ရပါမည်။',
           'password.required'=>'စကာား၀ှက်ထည့်ရန်လိုအပ်ပါသည်။',
           'password.min'=>'စကာား၀ှက်သည်အနည်းဆုံး ၆ လုံးဖြစ်ရပါမည်။'
        ];
    }
}
