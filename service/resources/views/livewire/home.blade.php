<div class="min-h-screen bg-white">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-800">光輪コーポレーション</h1>
                    </a>
                </div>
                <div class="flex items-center">
                    <h2 class="text-xl text-green-700">エフェクター蘇癒研究所</h2>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="bg-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="flex space-x-8">
                <li><a href="{{ route('home') }}" class="block py-4 px-2 text-white hover:bg-blue-700 transition">ホーム</a></li>
                <li><a href="{{ route('about') }}" class="block py-4 px-2 text-white hover:bg-blue-700 transition">サイト概要</a></li>
                <li><a href="{{ route('company') }}" class="block py-4 px-2 text-white hover:bg-blue-700 transition">会社案内</a></li>
                <li><a href="{{ route('bio') }}" class="block py-4 px-2 text-white hover:bg-blue-700 transition">商品購入</a></li>
                <li><a href="{{ route('contact') }}" class="block py-4 px-2 text-white hover:bg-blue-700 transition">お問合せ</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
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
                        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-4 rounded-lg shadow hover:shadow-lg transition">
                            <h4 class="font-bold text-center">スーパーバイオ２１</h4>
                        </div>
                    </a>
                    <!--
                    <a href="route('sukuaramin')" class="block">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-4 rounded-lg shadow hover:shadow-lg transition">
                            <h4 class="font-bold text-center">スクアラミンプルミエ</h4>
                        </div>
                    </a>
                    -->
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1">
                <!-- Hero Image Section (replacing Flash) -->
                <div class="bg-gradient-to-r from-blue-600 via-green-500 to-blue-600 rounded-lg shadow-lg p-8 mb-8">
                    <div class="text-center text-white">
                        <h2 class="text-4xl font-bold mb-4">エフェクター蘇癒研究所</h2>
                        <p class="text-xl">健康と自然の力を研究し、皆様の健やかな生活をサポートします</p>
                    </div>
                </div>

                <!-- News Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-blue-600 text-white p-4">
                        <h3 class="text-xl font-bold flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            最新情報
                        </h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex">
                                <dt class="w-24 text-sm text-gray-600 font-semibold">2011.11.17</dt>
                                <dd class="flex-1 text-gray-800">各コンテンツの内容を整理しました。</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-24 text-sm text-gray-600 font-semibold">2011.11.16</dt>
                                <dd class="flex-1 text-gray-800">HP開設しました。</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="flex justify-center space-x-8 mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-300 transition">ホーム</a>
                <a href="{{ route('about') }}" class="hover:text-blue-300 transition">サイト概要</a>
                <a href="{{ route('company') }}" class="hover:text-blue-300 transition">会社案内</a>
                <a href="{{ route('bio') }}" class="hover:text-blue-300 transition">商品紹介</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-300 transition">お問合せ</a>
            </nav>
            <div class="text-center text-sm">
                <p>〒274-0077　千葉県船橋市薬円台3-16-5-606　TEL:（047）466-2041（代）</p>
                <p class="mt-2">(C)2011 光輪コーポレーション</p>
            </div>
        </div>
    </footer>
</div>