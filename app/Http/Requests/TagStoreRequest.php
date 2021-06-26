<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'tag'=>'required|unique:categories,name',
            'image'=>'required'
        ];
    }
    public function messages()
    {
        return [
           'tag.required'=>'Tag ထည့်ရန်လိုအပ်ပါသည်။',
           'tag.unique'=>'Tag အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။',
           'image.required'=>'Tag ဓာတ်ပုံထည့်ရန်လိုအပ်ပါသည်။',
        ];
    }
}
