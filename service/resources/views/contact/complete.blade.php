@extends('components.layouts.app')

@section('title', 'お問い合わせ完了')

@section('content')
<div class="container w-7/12 rounded-lg">

    <p class="mb-3 text-xl font-semibold text-green-600">お問い合わせフォーム(完了)</p>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="alert alert-success">
                        <p class="mb-0">お問い合わせを受け付けました。<br>
                        ご入力いただいたメールアドレスに確認メールをお送りいたします。</p>
                    </div>

                    <p>内容を確認の上、担当者よりご連絡させていただきます。<br>
                    しばらくお待ちください。</p>

                    <div class="flex justify-center mt-3">
                    <!-- 送信ボタン -->
                        <a href="{{ route('home')}}"
                            class="px-8 py-3 bg-green-600 text-white font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                        >
                        トップページへ戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
