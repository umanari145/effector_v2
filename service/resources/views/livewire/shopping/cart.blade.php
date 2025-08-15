<div class="overflow-x-auto w-7/12 p-8 rounded-lg">
    <p class="text-xl font-semibold text-green-600">
        ショッピングカート
    </p>

    <!-- 商品選択画面 -->
    <div class="mt-6">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-500 bg-green-100 w-1/4">
                        {{ $item->name }}
                    </th>
                    <td class="px-6 py-4 text-gray-900 w-3/4">
                        <div class="flex items-center space-x-4">
                            <span>数量:</span>
                            <select wire:model.live="quantities.{{ $item->id }}" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                                @for($i = 0; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <span>価格: ¥{{ number_format($item->price) }}</span>
                            @if($quantities[$item->id] > 0)
                                <span class="text-green-600 font-semibold">
                                    小計: ¥{{ number_format($itemPrices[$item->id]) }}
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach

                <!-- 合計金額行 -->
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap text-left font-medium text-gray-700 bg-green-100">
                        合計金額
                    </th>
                    <td class="px-6 py-4 text-gray-900 font-bold text-lg">
                        ¥{{ number_format($totalPrice) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-center mt-3">
            <button wire:click="addToCart"
                    class="px-8 py-3 bg-green-600 text-white {{ $cartProp }} font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                    {{ $canAddCart }}
            >
                カートに入れる
            </button>
        </div>
    </div>
</div>
