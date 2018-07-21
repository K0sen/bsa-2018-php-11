<?php

namespace App\Request;


use Illuminate\Foundation\Http\FormRequest;

class AddLotFormRequest extends FormRequest
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
            'currency_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'short_name' =>   'required',
            'date_time_open' => 'required',
            'date_time_close' =>  'required',
            'price' => 'required'
        ];
    }
    public function messages()
    {
        return [
        ];
    }
}
