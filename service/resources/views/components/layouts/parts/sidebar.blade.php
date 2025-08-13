<!-- Sidebar -->
<aside class="w-64 flex-shrink-0">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Contents</h3>
        <ul class="space-y-2">
            <!--
            <li><a href="route('health.mechanism')" class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">健康のしくみ</a></li>
            <li><a href="route('fermentation') " class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">発酵食品の役目</a></li>
            <li><a href="route('natural.power') " class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">大切な自然の力</a></li>
            <li><a href="route('plant.power') " class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">自然界の植物パワー</a></li>
            <li><a href="route('bio') " class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">商品紹介1</a></li>
            <li><a href="route('sukuaramin') " class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">商品紹介2</a></li>
            <li><a href="route('qa') " class="block py-2 px-3 text-blue-700 hover:bg-blue-50 rounded">お客様Ｑ＆Ａ</a></li>
            -->
        </ul>
    </div>

    <!-- Product Banners -->
    <div class="mt-6 space-y-4">
        <a href="{{ route('bio') }}" class="block">
            <img src="{{ asset('image/baiobanner.png') }}" alt="スーパーバイオ２１">
        </a>
        <a href="{{ route('bio') }}" class="block">
            <img src="{{ asset('image/sukuarabanner.png') }}" alt="スーパーバイオ２１">
        </a>
    </div>
</aside>
