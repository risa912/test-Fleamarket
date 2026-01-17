<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'in:convenience,card'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
        ];
    }

    // 配送先（プロフィール）の存在チェック
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!auth()->user()->profile) {
                $validator->errors()->add(
                    'address',
                    '配送先を選択してください。'
                );
            }
        });
    }
}