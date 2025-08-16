@extends('components.layouts.app')

@section('title', 'お問い合わせフォーム')

@section('content')
<div class="overflow-x-auto w-7/12 rounded-lg">

    <p class="mb-3 text-xl font-semibold text-green-600">お問い合わせフォーム</p>

    <form method="POST" action="{{ route('contact.confirm') }}" class="mt-4">
        @csrf
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- お名前 -->
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/8">
                        お名前 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900 w-7/8">
                        <input type="text"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $validated['name']) }}"
                               placeholder="お名前を入力してください">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                <!-- 電話番号 -->
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        電話番号
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <div class="flex items-center space-x-2">
                            <input type="text"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('tel') border-red-500 @enderror"
                                   name="tel1"
                                   value="{{ old('tel1', $validated['tel1']) }}"
                                   placeholder="090"
                                   maxlength="4">
                            <span>-</span>
                            <input type="text"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('tel') border-red-500 @enderror"
                                   name="tel2"
                                   value="{{ old('tel2', $validated['tel2']) }}"
                                   placeholder="1234"
                                   maxlength="4">
                            <span>-</span>
                            <input type="text"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('tel') border-red-500 @enderror"
                                   name="tel3"
                                   value="{{ old('tel3', $validated['tel3']) }}"
                                   placeholder="5678"
                                   maxlength="4">
                        </div>
                        @error('tel')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                <!-- メールアドレス -->
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        メールアドレス <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="email"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('email1') border-red-500 @enderror"
                               id="email1"
                               name="email1"
                               value="{{ old('email1', $validated['email1']) }}"
                               placeholder="example@example.com">
                        @error('email1')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                <!-- メールアドレス（確認用） -->
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        メールアドレス<br>（確認用） <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="email"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('email2') border-red-500 @enderror"
                               id="email2"
                               name="email2"
                               value="{{ old('email2', $validated['email2']) }}"
                               placeholder="確認のため再度入力してください">
                        @error('email2')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                <!-- 郵便番号 -->
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        郵便番号
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <div class="flex items-center space-x-2">
                            <input type="text"
                                   class="w-16 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('zip') border-red-500 @enderror"
                                   name="zip1"
                                   value="{{ old('zip1', $validated['zip1'])}}"
                                   placeholder="123"
                                   maxlength="3">
                            <span>-</span>
                            <input type="text"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('zip') border-red-500 @enderror"
                                   name="zip2"
                                   value="{{ old('zip2', $validated['zip2']) }}"
                                   placeholder="4567"
                                   maxlength="4">
                        </div>
                        @error('zip')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>

                <!-- 住所 -->
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 bg-green-100 align-top">
                        住所
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('address') border-red-500 @enderror"
                                  id="address"
                                  name="address"
                                  rows="3"
                                  placeholder="住所を入力してください">{{ old('address', $validated['address']) }}</textarea>
                        @error('address')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-center mt-3">
            <!-- 送信ボタン -->
            <button type="submit"
                    class="px-8 py-3 bg-green-600 text-white font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                    name="send">
                確認画面へ
            </button>
        </div>
    </form>
</div>
@endsection
