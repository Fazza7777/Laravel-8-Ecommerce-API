<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name'=>'required',
            'category_id'=>'required',
            'subcat_id'=>'required',
            'tag_id'=>'required',
            'price'=>'required|numeric',
             'colors'=>'required',
             'sizes'=>'required',
             'description'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'category_id.required'=>'Category ထည့်ရန်လိုအပ်ပါသည်။',
           'subcat_id.required'=>'Sub Category ထည့်ရန်လိုအပ်ပါသည်။',
           'tag_id.required'=>'Tag ထည့်ရန်လိုအပ်ပါသည်။',
           'name.required'=>'Product ထည့်ရန်လိုအပ်ပါသည်။',
           'colors.required'=>'အရောင်ထည့်ရန်လိုအပ်ပါသည်။',
           'description.required'=>'အကြောင်းအရာထည့်ရန်လိုအပ်ပါသည်။',
           'price.required'=>'စေ◌ျးနူန်း ထည့်ရန်လိုအပ်ပါသည်။',
           'sizes.required'=>'အရွယ်အစား ထည့်ရန်လိုအပ်ပါသည်။',
           'price.numeric'=>'စေ◌ျးနူန်း သည် Number ဖြစ်ရပါမည်။',
           'name.unique'=>'Product အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။',

        ];
    }
}
