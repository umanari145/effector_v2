<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:100',
            'name_kana' => 'required|string|max:100|regex:/^[ア-ヲァ-ォャ-ヮヴ　\s]+$/u',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[0-9\-]+$/|min:10|max:15',
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/|size:8',
            'prefecture' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'building' => 'nullable|string|max:100',
            'same_as_customer' => 'boolean',
        ];

        // 配送先が購入者と異なる場合は配送先の必須バリデーションを追加
        if (!$this->input('same_as_customer')) {
            $rules['shipping_name'] = 'required|string|max:100';
            $rules['shipping_name_kana'] = 'required|string|max:100|regex:/^[ア-ヲァ-ォャ-ヮヴ　\s]+$/u';
            $rules['shipping_phone'] = 'required|regex:/^[0-9\-]+$/|min:10|max:15';
            $rules['shipping_postal_code'] = 'required|regex:/^\d{3}-\d{4}$/|size:8';
            $rules['shipping_prefecture'] = 'required|string|max:10';
            $rules['shipping_city'] = 'required|string|max:50';
            $rules['shipping_address'] = 'required|string|max:100';
            $rules['shipping_building'] = 'nullable|string|max:100';
        }

        return $rules;
    }

    /**
     * エラーメッセージ
     */
    public function messages()
    {
        return [
            'name.required' => 'お名前は必須です。',
            'name.max' => 'お名前は100文字以内で入力してください。',
            'name_kana.required' => 'お名前（カナ）は必須です。',
            'name_kana.regex' => 'お名前（カナ）はカタカナで入力してください。',
            'name_kana.max' => 'お名前（カナ）は100文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'phone.required' => '電話番号は必須です。',
            'phone.regex' => '電話番号は数字とハイフンのみで入力してください。',
            'phone.min' => '電話番号は10文字以上で入力してください。',
            'phone.max' => '電話番号は15文字以内で入力してください。',
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.regex' => '郵便番号は「000-0000」の形式で入力してください。',
            'postal_code.size' => '郵便番号は8文字で入力してください。',
            'prefecture.required' => '都道府県は必須です。',
            'prefecture.max' => '都道府県は10文字以内で入力してください。',
            'city.required' => '市区町村は必須です。',
            'city.max' => '市区町村は50文字以内で入力してください。',
            'address.required' => '住所は必須です。',
            'address.max' => '住所は100文字以内で入力してください。',
            'building.max' => '建物名は100文字以内で入力してください。',
            
            // 配送先情報のメッセージ
            'shipping_name.required' => '配送先お名前は必須です。',
            'shipping_name.max' => '配送先お名前は100文字以内で入力してください。',
            'shipping_name_kana.required' => '配送先お名前（カナ）は必須です。',
            'shipping_name_kana.regex' => '配送先お名前（カナ）はカタカナで入力してください。',
            'shipping_name_kana.max' => '配送先お名前（カナ）は100文字以内で入力してください。',
            'shipping_phone.required' => '配送先電話番号は必須です。',
            'shipping_phone.regex' => '配送先電話番号は数字とハイフンのみで入力してください。',
            'shipping_phone.min' => '配送先電話番号は10文字以上で入力してください。',
            'shipping_phone.max' => '配送先電話番号は15文字以内で入力してください。',
            'shipping_postal_code.required' => '配送先郵便番号は必須です。',
            'shipping_postal_code.regex' => '配送先郵便番号は「000-0000」の形式で入力してください。',
            'shipping_postal_code.size' => '配送先郵便番号は8文字で入力してください。',
            'shipping_prefecture.required' => '配送先都道府県は必須です。',
            'shipping_prefecture.max' => '配送先都道府県は10文字以内で入力してください。',
            'shipping_city.required' => '配送先市区町村は必須です。',
            'shipping_city.max' => '配送先市区町村は50文字以内で入力してください。',
            'shipping_address.required' => '配送先住所は必須です。',
            'shipping_address.max' => '配送先住所は100文字以内で入力してください。',
            'shipping_building.max' => '配送先建物名は100文字以内で入力してください。',
        ];
    }
}