<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAddressRequest extends FormRequest
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
            'destination_postcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'destination_address' => ['required', 'string'],
            'destination_building' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'destination_postcode.required' => '郵便番号を入力してください',
            'destination_postcode.regex' => '郵便番号はハイフンを含めて、8文字で入力してください',
            'destination_address.required' => '住所を入力してください',
        ];
    }
}