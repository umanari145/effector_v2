<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactFormController extends Controller
{
    /**
     * フォーム表示
     */
    public function index()
    {
        return view('contact.form');
    }

    /**
     * フォーム確認
     */
    public function confirm(ContactFormRequest $request)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 電話番号とZIPコードを結合
        $validated['tel'] = $this->formatTel($validated['tel1'] ?? '', $validated['tel2'] ?? '', $validated['tel3'] ?? '');
        $validated['zip'] = $this->formatZip($validated['zip1'] ?? '', $validated['zip2'] ?? '');

        // セッションにデータを保存
        session(['form_data' => $validated]);

        return view('contact.confirm', compact('validated'));
    }

    /**
     * フォーム送信完了
     */
    public function complete()
    {
        // セッションからデータを取得
        $formData = session('form_data');

        if (!$formData) {
            return redirect()->route('contact.form');
        }

        try {
            // メール送信
            Mail::to($formData['email1'])->send(new ContactFormMail($formData));
            // セッションからデータを削除
            session()->forget('form_data');
            return view('contact.complete');
        } catch (\Exception $e) {
            return back()->with('error', 'メール送信に失敗しました。');
        }
    }

    /**
     * 電話番号フォーマット
     */
    private function formatTel($tel1, $tel2, $tel3)
    {
        if (trim($tel1) === '' && trim($tel2) === '' && trim($tel3) === '') {
            return '';
        }
        return $tel1 . '-' . $tel2 . '-' . $tel3;
    }

    /**
     * 郵便番号フォーマット
     */
    private function formatZip($zip1, $zip2)
    {
        if (trim($zip1) === '' && trim($zip2) === '') {
            return '';
        }
        return $zip1 . '-' . $zip2;
    }
}
