<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // いいね操作のときはバリデーションしない
        if ($this->has('like')) {
            return [];
        }

        return [
            'comment' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'コメントを入力してください',
            'comment.max'      => 'コメントは255文字以内で入力してください',
        ];
    }
}