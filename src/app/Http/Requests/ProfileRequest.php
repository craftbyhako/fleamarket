<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            //
            'user_name'=>['required', 'max:20'],
            'image'=>['nullable', 'mimes:jpeg,png'],
            'postcode'=>['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'=>['required', 'string'],
        ];
    }
        
    public function messages()
    {
        return [
            'user_name.required'=>['ユーザー名を入力してください'],
            'user_name.max'=>['ユーザー名は２０文字内で入力してください'],
            'image.mimes'=>['拡張子が.jpegまたは.pngのファイルを選択してください'],
            'postcode.required'=>['郵便番号を入力してください'],
            'postcode.regex'=>['郵便番号はハイフンを含めて、８文字で入力してください'],
            'address.required'=>['住所を入力してください']
        ];
    }
}
