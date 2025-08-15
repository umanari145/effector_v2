<div class="overflow-x-auto">
    <p class="text-xl font-semibold text-green-600">
        お客様情報
    </p>

    <form wire:submit.prevent="submit" class="mt-6">
        <!-- カート内容表示 -->
        @if(count($cartItems) > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">ご注文内容</h3>
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartItems as $cartItem)
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/4">
                            {{ $cartItem['name'] }}
                        </th>
                        <td class="px-6 py-4 text-gray-900 w-3/4">
                            数量: {{ $cartItem['quantity'] }}個　価格: ¥{{ number_format($cartItem['price']) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                            合計金額
                        </th>
                        <td class="px-6 py-4 text-gray-900 font-bold text-lg">
                            ¥{{ number_format($totalPrice) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- カート内容変更ボタン -->
        <div class="text-center mb-6">
            <button type="button"
                    wire:click="backToCart"
                    class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg">
                カート内容を変更する
            </button>
        </div>
        @endif

        <!-- 購入者情報 -->
        <h3 class="text-lg font-semibold mb-3">購入者情報</h3>
        <table class="min-w-full mb-6 divide-y divide-gray-200 border border-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/4">
                        お名前 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900 w-3/4">
                        <input type="text"
                               wire:model.live="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror"
                        >
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        お名前（カナ） <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="name_kana"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('name_kana') border-red-500 @enderror"
                               title="カタカナで入力してください"
                        >
                        @error('name_kana')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        電話番号 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="tel"
                               wire:model.live="phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('phone') border-red-500 @enderror"
                               title="電話番号は数字とハイフンのみで入力してください"
                               placeholder="例: 03-1234-5678"
                        >
                        @error('phone')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        メールアドレス <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="email"
                               wire:model.live="email"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        郵便番号 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="postal_code"
                               class="w-32 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('postal_code') border-red-500 @enderror"
                               title="郵便番号は「000-0000」の形式で入力してください"
                               placeholder="000-0000"
                               maxlength="8"
                        >
                        @error('postal_code')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        都道府県 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <select wire:model.live="prefecture"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('prefecture') border-red-500 @enderror"
                        >
                            <option value="">選択してください</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}">{{ $pref }}</option>
                            @endforeach
                        </select>
                        @error('prefecture')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        市区町村 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="city"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('city') border-red-500 @enderror"
                               placeholder="例: 千代田区"
                        >
                        @error('city')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 bg-green-100 align-top">
                        住所 <span class="text-red-500">*</span>
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="address"
                               placeholder="例: 霞が関1-1-1"
                               class="w-full mb-2 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('address') border-red-500 @enderror"
                        >
                        <input type="text"
                               wire:model.live="building"
                               placeholder="建物名・部屋番号（任意）"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @error('building') border-red-500 @enderror">
                        @error('address')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        @error('building')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 配送先情報 -->
        <h3 class="text-lg font-semibold mb-3 mt-8">配送先情報</h3>

        <!-- 購入者と同じかどうかのチェックボックス -->
        <div class="mb-4">
            <label class="flex items-center space-x-2">
                <input type="checkbox"
                       wire:model.live="same_as_customer"
                       class="form-checkbox h-5 w-5 text-green-600">
                <span class="text-gray-700">購入者と同じ住所に配送する</span>
            </label>
        </div>

        <table class="min-w-full mb-6 divide-y divide-gray-200 border border-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/4">
                        お名前 @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900 w-3/4">
                        <input type="text"
                               wire:model.live="shipping_name"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_name') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif>
                        @error('shipping_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        お名前（カナ） @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="shipping_name_kana"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_name_kana') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif
                               title="カタカナで入力してください">
                        @error('shipping_name_kana')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        電話番号 @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="tel"
                               wire:model.live="shipping_phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_phone') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif
                               title="電話番号は数字とハイフンのみで入力してください"
                               placeholder="例: 03-1234-5678">
                        @error('shipping_phone')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        郵便番号 @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="shipping_postal_code"
                               class="w-32 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_postal_code') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif
                               title="郵便番号は「000-0000」の形式で入力してください"
                               placeholder="000-0000"
                               maxlength="8">
                        @error('shipping_postal_code')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        都道府県 @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <select wire:model.live="shipping_prefecture"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_prefecture') border-red-500 @enderror"
                                @if($same_as_customer) disabled @endif>
                            <option value="">選択してください</option>
                            @foreach($prefectures as $pref)
                                <option value="{{ $pref }}">{{ $pref }}</option>
                            @endforeach
                        </select>
                        @error('shipping_prefecture')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        市区町村 @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="shipping_city"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_city') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif
                               placeholder="例: 千代田区">
                        @error('shipping_city')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 text-left font-medium text-gray-500 bg-green-100 align-top">
                        住所 @if(!$same_as_customer)<span class="text-red-500">*</span>@endif
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        <input type="text"
                               wire:model.live="shipping_address"
                               placeholder="例: 霞が関1-1-1"
                               class="w-full mb-2 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_address') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif>
                        <input type="text"
                               wire:model.live="shipping_building"
                               placeholder="建物名・部屋番号（任意）"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500 @if($same_as_customer) bg-gray-100 text-gray-500 @endif @error('shipping_building') border-red-500 @enderror"
                               @if($same_as_customer) disabled @endif>
                        @error('shipping_address')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        @error('shipping_building')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 送信ボタン -->
        <div class="text-center mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200">
                確認画面へ進む
            </button>
        </div>
    </form>


