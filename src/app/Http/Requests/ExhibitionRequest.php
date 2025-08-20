<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name' => ['required'],
            'image' => ['required', 'mimes:jpeg,png'],
            'brand' => ['nullable'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'max:255'],
            'condition_id' => ['required', 'exists:conditions,id'],
            'categories' => ['required','array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

    public function messages() 
    {
        return [
            'item_name.required' => '商品名を入力してください',
            'image.required' => '商品画像を添付してください',
            'image.mimes' => '画像は.pngまたは.jpegの形式で添付してください',
            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数値で入力してください',
            'price.min' => '販売価格は０円以上で入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明を２５５文字以内で入力してください',
            'condition_id.required' => '商品の状態を選択してください',
            'condition_id.exists' => '選択した商品の状態が無効です',
            'categories.required' => 'カテゴリを選択してください',
            'categories.array' => 'カテゴリは正しく選択してください',
            'categories.*.exists' => 'カテゴリの選択に誤りがあります'
        ];
    }
}
