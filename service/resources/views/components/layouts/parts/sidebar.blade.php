<!-- Sidebar -->
<aside class="w-64 flex-shrink-0">
    <div class="bg-green-600 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4 text-white border-b pb-2">Contents</h3>
        <ul class="space-y-2">
            <li class=""><a href="{{ route('health.mechanism') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">健康のしくみ</a></li>
            <li class=""><a href="{{ route('fermentation') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">発酵食品の役目</a></li>
            <li class=""><a href="{{ route('natural.power') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">大切な自然の力</a></li>
            <li class=""><a href="{{ route('plant.power') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">自然界の植物パワー</a></li>
            <li class=""><a href="{{ route('bio') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">商品紹介1</a></li>
            <li class=""><a href="{{ route('sukuaramin') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">商品紹介2</a></li>
            <li class=""><a href="{{ route('qa') }}" class="block py-2 px-3 text-white hover:bg-green-500 transition">お客様Ｑ＆Ａ</a></li>
        </ul>
    </div>

    <!-- Product Banners -->
    <div class="mt-6 space-y-4">
        <a href="{{ route('bio') }}" class="block">
            <img src="{{ asset('image/baiobanner.png') }}" alt="スーパーバイオ２１">
        </a>
        <a href="{{ route('sukuaramin') }}" class="block">
            <img src="{{ asset('image/sukuarabanner.png') }}" alt="スーパーバイオ２１">
        </a>
    </div>
</aside>
