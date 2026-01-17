<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['nullable', 'file', 'mimes:jpeg,png'],
            'categories' => ['required'],
            'condition_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => '画像は jpeg または png のみアップロードできます',
            'categories.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数値で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
        ];
    }
}
