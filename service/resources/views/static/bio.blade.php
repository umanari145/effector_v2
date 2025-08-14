@extends('components.layouts.app')

@section('title', 'スーパーバイオ21')

@section('content')
<div id="paragraph2" class="w-7/12 bg-green-100 p-8 rounded-lg">
    <div class="title">
        <img src="{{ asset('image/baiobar.png') }}" alt="スーパーバイオ21" />
    </div>
    <div class="mt-2">
        <img src="{{ asset('image/baiophoto.png') }}" class="mt-2" alt="スーパーバイオ21" /><br />
        パパイヤ酵母発酵酵素食品「スーパーバイオ21」「スーパーバイオ21」は、<br />
        多種多様の酵素やアミノ酸ビタミン・ミネラルなどを含んでいる"青パパイヤ"を<br />
        主原料とし、複合微生物(乳酸菌・ラク酸菌・クエン酸菌・酵母など)<br />
        の働きを利用して、自然環境下で発酵・熟成して生まれたパパイヤ酵素発酵食品です。<br />
        (製造特許番号は3370302)<br />
        <p class="mousikomi mt-2">
            <a href="cart.php" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                お申し込みはこちらをクリック
            </a>
        </p>
        <hr class="my-6 border-t-1 border-gray-300">
        <p class="mt-3 text-xl font-semibold text-green-600">スーパーバイオ２１の特性について</p>
        <p class="mt-2">
        製造特許３３７０３０２号　スーパーバイオ21、<br>
        パパイヤ酵母発酵酵素食品の特殊な働き、その結論は次の通りとなります。<br><br>

        スーパーバイオ２１はクルードパパインを多く含有している<br>
        カリカパパイヤを日本、古来の食品から得た、独自の酵母酵素をバイオ<br>
        ドッキングさせ、顆粒化したものです。<br><br>

        製造工程では抽出、純粋化などの化学工程を一切排除し 、培養、発酵<br>
        養生したバイオ触媒と言えます。<br><br>

        呼吸をする、体を動かす、体温を保つ、食物を消化吸収し排泄するなどで<br>
        身体機能のすべての働きを促す触媒の役目を行う物質、これが酵素です。<br><br>

        このパパイヤ発酵酵素には特質するべき天然成分の中の蛋白質分解<br>
        脂肪分解、糖質分解などに秘められた優秀な酵素があります。<br><br>

        この蛋白質と脂肪の両方に作用する酵素を共存する植物は<br>
        スーパーバイオ21に含まれるパパイヤの発酵酵素以外には無いと<br>
        言えます。 <br><br>

        スーパーバイオ21に含まれる酵母発酵酵素食品の酵素の働きによって<br>
        難知性疾患・慢性病など、多くの生活習慣病に対して信じられないような<br>
        様々な改善現象が在るのは事実なのですが、薬事法等の問題があります<br>
        ので症例につきましては、会員の皆様には、別のサイトを通して<br>
        お知らせさせて頂ます。
        </p>
        <p class="mousikomi mt-2">
            <a href="cart.php" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                お申し込みはこちらをクリック
            </a>
        </p>
        <hr class="my-6 border-t-1 border-gray-300">
        <p class="mt-3 text-xl font-semibold text-green-600">お召し上がり方</p>
        <p class="mt-4 mb-4">
        食べられる方は、健康食品として1日1袋(錠剤タイプ10粒)を、その後、<br>
        身体の順応状態をみて、1日3袋(錠剤タイプ30粒)程度を目安におやすみ前か<br>
        食事の後にお召し上がり下さい。<br><br>

        ※小児(体重30kg未満)の場合は、1袋の1/3～1袋(錠剤タイプ3粒～10粒)程度を<br>
        目安としてお召し上がり下さい。<br><br>

        スーパーバイオ21酵母発酵酵素健康補助食品は、消費者の衛生的な管理と<br>
        主に使用上の便宜を図り、１箱健康維持には１ヶ月３０袋、１袋は<br>
        ３グラムのスティックとなっていますので、お出かけの際にもバッグ<br>
        ポケットなどの 携帯の便利さが特徴となっています。
        </p>
        <p class="mousikomi mt-2 mb-8">
            <a href="{{ route('cart.index') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                お申し込みはこちらをクリック
            </a>
        </p>

        <hr class="my-6 border-t-1 border-gray-300">
        <div class="flex justify-center">
            <a href="{{ route('plant-power') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
                前へ戻る
            </a>
            <a href="#" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
                ページトップに戻る
            </a>
            <a href="{{ route('sukuaramin') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                次に進む
            </a>
        </div>
    </div>
</div>
@endsection
