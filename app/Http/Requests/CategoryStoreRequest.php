<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'category'=>'required|unique:categories,name',
            'image'=>'required'
        ];
    }
    public function messages()
    {
        return [
           'category.required'=>'Category ထည့်ရန်လိုအပ်ပါသည်။',
           'category.unique'=>'Category အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။',
           'image.required'=>'category ဓာတ်ပုံထည့်ရန်လိုအပ်ပါသည်။',
        ];
    }
}
