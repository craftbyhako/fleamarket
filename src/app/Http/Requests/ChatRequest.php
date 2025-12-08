<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
        $rules = [
            'draft_message' => ['nullable', 'max:400'],
            'image' => ['nullable', 'mimes:jpeg,png'],
        ];

        // ★送信ボタンが押された場合のみ本文必須
        if ($this->has('send_message')) {
            $rules['draft_message'][] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'draft_message.required' => '本文を入力してください',
            'draft_message.max' => '本文は４００文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください'
        ];
    }
}
