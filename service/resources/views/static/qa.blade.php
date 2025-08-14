@extends('components.layouts.app')

@section('title', 'お客様Q&A')

@section('content')
<div id="paragraph2" class="w-7/12 bg-green-100 p-8 rounded-lg">
    <div class="title">
        <img src="{{ asset('image/qa.png') }}" alt="お客様Q&A" />
    </div>
    <p class="mt-3 text-xl font-semibold text-green-600">小さな子供や妊娠中の人でも食べられますか？</p>
    <p class="mt-2">
        弊社商品は乳幼児からお年寄り、また妊娠中の方など幅広くご愛用<br>
        いただけます。<br>
        注）「スクアラミン プルミエ」の食べ方について・・・<br><br>

        「スクアラミン プルミエ」を小さなお子様や飲み込む力の弱い方が<br>
        お召しあがりになる際は、数粒を一度に飲み込まないで1粒ずつお水<br>
        またはお湯などで、ゆっくりお召しあがりください。<br>
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <p class="mt-3 text-xl font-semibold text-green-600">食べる時間（タイミング）はいつがいいのですか？</p>
    <p class="mt-2">
        基本的にはおやすみ前かお食事の後にお召しあがりください。
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <p class="mt-3 text-xl font-semibold text-green-600">薬との併用はいいのですか？</p>
    <p class="mt-2">
        基本的にはかまいませんが、「スーパーバイオ２１」を薬服用後<br>
        ３０分経ってからお召しあがりください。
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <p class="mt-3 text-xl font-semibold text-green-600">ペットにも食べさせていいのですか？</p>
    <p class="mt-2">
        毛なみがよくなり元気になった！というお声をお客様から<br>
        いただきました。ペットの大きさにもよりますが、<br>
        「スーパーバイオ２１」についてはまずは１／４袋くらいから<br>
        様子をみていただくとよいでしょう。
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <p class="mt-3 text-xl font-semibold text-green-600">植物にもいいのですか？</p>
    <p class="mt-2">
        「スーパーバイオ２１」の空き袋にお水を入れて植物に与えると、<br>
        植物がイキイキしてきた！というお声をお客様からいただきました。
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <p class="mt-3 text-xl font-semibold text-green-600">お料理にもつかえますか？</p>
    <p class="mt-2">
        「スーパーバイオ２１」を調理の下ごしらえにつかって、<br>
        お肉がやわらかくなった！というお声をお客様からいただきました。
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <p class="mt-3 text-xl font-semibold text-green-600">商品の保管はどうしたほうがいいのですか？</p>
    <p class="mt-2">
        品質保持のために高温になる車中や直射日光のあたる場所に長時間放置<br>
        されないようにお願いいたします。<br><br>

        また「スクアラミン プルミエ」については、お客様に新鮮な商品を<br>
        お届けするために冷蔵保存・冷蔵輸送しております。<br><br>

        お客様のお手元に届きました商品は、冷蔵庫で保管していただく<br>
        ことをお勧めします。
    </p>

    <hr class="my-6 border-t-1 border-gray-300">
    <div class="flex justify-center">
        <a href="{{ route('sukuaramin') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
            前へ戻る
        </a>
        <a href="#" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
            ページトップに戻る
        </a>
    </div>
    </div>
</div>
@endsection
