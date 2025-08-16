@extends('components.layouts.app')

@section('title', 'お問い合わせ内容確認')

@section('content')
<div class="container w-7/12 rounded-lg">
    <p class="mb-3 text-xl font-semibold text-green-600">お問い合わせフォーム(確認)</p>

    <div class="row justify-content">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>以下の内容で送信します。よろしければ「送信する」ボタンをクリックしてください。</p>

                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200 mt-3">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/8">お名前</th>
                                <td class="px-6 py-4 text-gray-900 w-7/8">{{ $validated['name'] }}</td>
                            </tr>
                            @if(!empty($validated['tel']))
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/8">電話番号</th>
                                <td class="px-6 py-4 text-gray-900 w-7/8">{{ $validated['tel'] }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/8">メールアドレス</th>
                                <td class="px-6 py-4 text-gray-900 w-7/8">{{ $validated['email1'] }}</td>
                            </tr>
                            @if(!empty($validated['zip']))
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/8">郵便番号</th>
                                <td class="px-6 py-4 text-gray-900 w-7/8">{{ $validated['zip'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($validated['address']))
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/8">住所</th>
                                <td class="px-6 py-4 text-gray-900 w-7/8">{{ $validated['address'] }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>


                    <div class="flex justify-center mt-3">
                        <a href="{{ route('contact.form') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
                            前へ戻る
                        </a>

                        <form method="POST" action="{{ route('contact.complete') }}" id="contactForm" class="mb-0">
                            @csrf
                            <button
                                name="send"
                                type="submit"
                                id="submitBtn"
                                class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submitText">送信する</span>
                                <svg id="loadingSpinner" class="animate-spin -mr-1 ml-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');

    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitText.textContent = '送信中...';
        loadingSpinner.classList.remove('hidden');
    });
});
</script>
