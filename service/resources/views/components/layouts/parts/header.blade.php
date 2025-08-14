<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center py-6">
            <h1>
                <a href="{{ route('home') }}">
                    <img src="{{ asset('image/head_titile.gif') }}" class="hover:opacity-40 transition" alt="光輪コーポレーション" >
                </a>
            </h1>
            <h2 class="text-xl text-green-700">
                <a href="{{ route('home') }}" >
                    <img src="{{ asset('image/maintitle.gif') }}" class="hover:opacity-40 transition" alt="エフェクター蘇癒研究所" />
                </a>
            </h2>
        </div>
    </div>
</header>

<nav class="bg-green-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ul class="flex items-center justify-center space-x-2">
            <li class="w-32 text-center"><a href="{{ route('home') }}" class="block py-4 px-2 text-white hover:bg-green-500 transition">ホーム</a></li>
            <li class="w-32 text-center"><a href="{{ route('about') }}" class="block py-4 px-2 text-white hover:bg-green-500 transition">サイト概要</a></li>
            <li class="w-32 text-center"><a href="{{ route('company') }}" class="block py-4 px-2 text-white hover:bg-green-500 transition">会社案内</a></li>
            <li class="w-32 text-center"><a href="{{ route('bio') }}" class="block py-4 px-2 text-white hover:bg-green-500 transition">商品購入</a></li>
            <li class="w-32 text-center"><a href="{{ route('contact.form') }}" class="block py-4 px-2 text-white hover:bg-green-500 transition">お問い合わせ</a></li>
        </ul>
    </div>
</nav>
