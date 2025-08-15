<div class="overflow-x-auto">
    <p class="text-xl font-semibold text-green-600">
        ご注文確認
    </p>

    <!-- ご注文内容 -->
    @if(count($cartItems) > 0)
    <div class="mb-6 mt-6">
        <h3 class="text-lg font-semibold mb-3">ご注文内容</h3>
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">商品名</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">単価</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">数量</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">小計</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($cartItems as $cartItem)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                        {{ $cartItem['name'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                        ¥{{ number_format($cartItem['unit_price']) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                        {{ $cartItem['quantity'] }}個
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                        ¥{{ number_format($cartItem['price']) }}
                    </td>
                </tr>
                @endforeach
                <tr class="bg-green-50">
                    <th colspan="3" class="px-6 py-4 text-right font-medium text-gray-900">
                        合計金額
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-bold text-lg">
                        ¥{{ number_format($totalPrice) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <div class="flex justify-center items-center mt-4">
        <button type="button"
                wire:click="backToCart"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
            カート内容を変更
        </button>
    </div>


    <!-- 購入者情報 -->
    <div class="mb-6 mt-2">
        <h3 class="text-lg font-semibold mb-3">購入者情報</h3>
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/4">
                        お名前
                    </th>
                    <td class="px-6 py-4 text-gray-900 w-3/4">
                        {{ $customerInfo['name'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        お名前（カナ）
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $customerInfo['name_kana'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        電話番号
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $customerInfo['phone'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        メールアドレス
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $customerInfo['email'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        郵便番号
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $customerInfo['postal_code'] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                        住所
                    </th>
                    <td class="px-6 py-4 text-gray-900">
                        {{ $customerInfo['prefecture'] ?? '' }} {{ $customerInfo['city'] ?? '' }}<br>
                        {{ $customerInfo['address'] ?? '' }}
                        @if(!empty($customerInfo['building']))
                            <br>{{ $customerInfo['building'] }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 配送先情報 -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3">配送先情報</h3>
        @if($shippingInfo['same_as_customer'] ?? false)
            <div class="p-4 bg-gray-50 border border-gray-200 rounded">
                <p class="text-gray-700">購入者と同じ住所に配送します</p>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/4">
                            お名前
                        </th>
                        <td class="px-6 py-4 text-gray-900 w-3/4">
                            {{ $shippingInfo['shipping_name'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                            お名前（カナ）
                        </th>
                        <td class="px-6 py-4 text-gray-900">
                            {{ $shippingInfo['shipping_name_kana'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                            電話番号
                        </th>
                        <td class="px-6 py-4 text-gray-900">
                            {{ $shippingInfo['shipping_phone'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                            郵便番号
                        </th>
                        <td class="px-6 py-4 text-gray-900">
                            {{ $shippingInfo['shipping_postal_code'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100">
                            住所
                        </th>
                        <td class="px-6 py-4 text-gray-900">
                            {{ $shippingInfo['shipping_prefecture'] ?? '' }} {{ $shippingInfo['shipping_city'] ?? '' }}<br>
                            {{ $shippingInfo['shipping_address'] ?? '' }}
                            @if(!empty($shippingInfo['shipping_building']))
                                <br>{{ $shippingInfo['shipping_building'] }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>

    <!-- 操作ボタン -->
    <div class="flex justify-center items-center mt-3">
        <button type="button"
                wire:click="backToCustomer"
                class="bg-green-600 mr-4 text-white font-bold py-2 px-6 rounded-lg">
            お客様情報を変更
        </button>
        <button type="button"
                wire:click="confirmOrder"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg">
            注文を確定する
        </button>
    </div>
</div>
