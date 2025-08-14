<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * リクエストの認証を判定
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'tel1' => 'nullable|string|max:4',
            'tel2' => 'nullable|string|max:4',
            'tel3' => 'nullable|string|max:4',
            'email1' => 'required|email|max:255',
            'email2' => 'required|email|max:255|same:email1',
            'zip1' => 'nullable|string|regex:/^[0-9]{3}$/',
            'zip2' => 'nullable|string|regex:/^[0-9]{4}$/',
            'address' => 'nullable|string|max:500',
            'sample' => 'nullable|string',
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages()
    {
        return [
            'name.required' => 'お名前は必須項目です。',
            'tel1.max' => '電話番号の形式が正しくありません。',
            'tel2.max' => '電話番号の形式が正しくありません。',
            'tel3.max' => '電話番号の形式が正しくありません。',
            'email1.required' => 'メールアドレスは必須項目です。',
            'email1.email' => 'メールアドレスの形式が正しくありません。',
            'email2.required' => 'メールアドレス（確認用）は必須項目です。',
            'email2.email' => 'メールアドレス（確認用）の形式が正しくありません。',
            'email2.same' => 'メールアドレスが一致しません。',
            'zip1.regex' => '郵便番号の形式が正しくありません。',
            'zip2.regex' => '郵便番号の形式が正しくありません。',
        ];
    }

    /**
     * バリデーション後の処理
     */
    protected function passedValidation()
    {
        // 電話番号の複合バリデーション
        if ($this->hasAnyTelField() && !$this->hasAllTelFields()) {
            $this->validator->errors()->add('tel', '電話番号は全ての項目を入力してください。');
        }

        // 郵便番号の複合バリデーション
        if ($this->hasAnyZipField() && !$this->hasAllZipFields()) {
            $this->validator->errors()->add('zip', '郵便番号は全ての項目を入力してください。');
        }
    }

    /**
     * 電話番号のいずれかのフィールドが入力されているか
     */
    private function hasAnyTelField()
    {
        return !empty($this->tel1) || !empty($this->tel2) || !empty($this->tel3);
    }

    /**
     * 電話番号のすべてのフィールドが入力されているか
     */
    private function hasAllTelFields()
    {
        return !empty($this->tel1) && !empty($this->tel2) && !empty($this->tel3);
    }

    /**
     * 郵便番号のいずれかのフィールドが入力されているか
     */
    private function hasAnyZipField()
    {
        return !empty($this->zip1) || !empty($this->zip2);
    }

    /**
     * 郵便番号のすべてのフィールドが入力されているか
     */
    private function hasAllZipFields()
    {
        return !empty($this->zip1) && !empty($this->zip2);
    }
}
