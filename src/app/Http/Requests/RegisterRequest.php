<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'user_name'=>['required', 'max:20'],
            'email'=>['required', 'email'],
            'password'=>['required', 'min:8', 'confirmed'],
            'password_confirmation'=>['required'],
        ];
    }

    public function messages(){
        return [
            'user_name.required'=>'お名前を入力してください',
            'user_name.max'=>'20文字以内で入力してください',
            'email.required'=>'メールアドレスを入力してください',
            'email.email'=>'メールアドレスは「ユーザー名＠ドメイン」形式で入力してください',
            'password.required'=>'パスワードを入力してください',
            'password.min'=>'パスワードは８文字以上で入力してください',
            'password_confirmation.required'=>'確認用パスワードを入力してください',
            'password_confirmation.confirmed'=>'パスワードと一致しません'
        ];
    }
}
