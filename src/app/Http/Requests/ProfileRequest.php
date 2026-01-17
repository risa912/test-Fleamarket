<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'file', 'mimes:jpeg,png'], 
            'name' => ['required', 'string', 'max:20'], 
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.mimes' => '画像は jpeg または png のみアップロードできます',
            'name.required' => 'ユーザー名は必須です',
            'name.max' => 'ユーザー名は20文字以内で入力してください',
            'postal_code.required' => '郵便番号は必須です',
            'postal_code.regex' => '郵便番号はハイフン付き8文字で入力してください',
            'address.required' => '住所は必須です',
        ];
    }
}