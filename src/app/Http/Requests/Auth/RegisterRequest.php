<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.confirmed' => 'パスワードと一致しません', 
        ];
    }

    public function withValidator($validator)
    {
    $validator->after(function ($validator) {
        $password = $this->input('password');
        $passwordConfirmation = $this->input('password_confirmation');

        // 確認用パスワード未入力
        if ($passwordConfirmation === null || $passwordConfirmation === '') {
            $validator->errors()->add('password_confirmation', '確認用パスワードを入力してください');
        }
        // パスワードと不一致
        elseif ($password !== $passwordConfirmation) {
            $validator->errors()->add('password_confirmation', 'パスワードと一致しません');
        }
    });
    }
}

