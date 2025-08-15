@extends('components.layouts.app')

@section('title', 'スクアラミンプルミエ')

@section('content')
<div id="paragraph2" class="w-7/12 bg-green-100 p-8 rounded-lg">
    <div class="title">
        <img src="{{ asset('image/sukuarabar.png') }}" alt="スクアラミンプルミエ" />
    </div>
    <div class="mt-2">
        <img src="{{ asset('image/sukuaraphoto.png') }}" class="mt-2" alt="スクアラミンプルミエ" /><br />
        <p class="sentence">
        「スクアラミン プルミエ」は、深海に棲むアイ鮫の肝臓を厳しい温度管理のもとに<br>
        「加熱」を一切せず、「冷凍自然分離法」によってつくられた天然生肝油100％の自然食品です。<br><br>

        非加熱処理製造のためアイ鮫の肝臓に含まれる有効成分が壊れることなく<br>
        天然最強の抗生物質といわれている"スクアラミン"をはじめ<br>
        スクワレン・ビタミン・ミネラルなど人間の持つ機能を高めるといわれる<br>
        多種類の良質な成分が豊富に含まれています。<br>
        (製法特許番号は1543258)
        </p>

        <p class="mousikomi mt-2">
            <a href="{{ route('shopping.cart') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                お申し込みはこちらをクリック
            </a>
        </p>
        <hr class="my-6 border-t-1 border-gray-300">
        <p class="mt-3 text-xl font-semibold text-green-600">スクアラミン プルミエに含まれる成分のはたらき</p>
        <p class="mt-2">
            ●スクアラミン<br>
            強い殺菌作用があり、ガン細胞の成長・増殖に必要な血管をつくらせない<br>
            血管新生抑制作用を持つ"天然最強"の抗生物質です。<br><br>

            スクアラミンVSガン細胞<br><br>

            ●スクワレン<br>
            肌や粘膜などから浸透しやすく殺菌と抗酸化力に優れ、細胞の働きを活発<br>
            にし新陳代謝を促す働きを持ちます。<br>
            (アイ鮫の肝臓に最も多く含まれる成分)<br><br>

            ●炭素鎖27(R27)<br>
            赤血球の持つ変形能力を高め、血液を活性化するとともに血管を保護し<br>
            強化する働きを持ちます。<br>
            (体重10kgの深海鮫に10mgしか含まれない稀少な成分)<br><br>

            ●アルキルグリセロール(AKGs)<br>
            天然の脂肪物質で、人間の肝臓・腎臓・母乳などにも自然に存在し、<br>
            人体の免疫強化に不可欠な白血球の生成・増加に重要な働きを持ちます。<br><br>

            ●オメガ３脂肪酸(ω-3脂肪酸・オメガ3油)<br>
            体内では生成されない身体に必要不可欠な必須脂肪酸(DHA・EPAなど)。<br>
            血液をきれいにし、中性脂肪を分解する働きを持ちます。<br><br>

            ●ビタミンＡ<br>
            脂溶性ビタミンのひとつ。細胞膜を元気にするなどの働きを持ちます。<br><br>

            ●ビタミンＥ<br>
            脂溶性ビタミンのひとつ。身体のサビを取り、老化を防止する抗酸化<br>
            作用の働きを持ちます。<br><br>

            ●ミネラル群<br>
            身体に必要な栄養素で、細胞間の情報伝達や各器官の働きをスムーズ<br>
            にするなど、身体の中で"潤滑油"的役割を持ちます。<br><br>

            ※各成分の説明は原材料に関する一般的なものです。<br><br><br>


            保管方法について<br><br>

            お客様に新鮮な商品をお届けするために、弊社では冷蔵保管・冷蔵輸送<br>
            しております。<br><br>

            お客様のお手元に届きました商品は、冷蔵庫で保管していただくことを<br>
            お勧めします。
        </p>
        <p class="mousikomi mt-2">
            <a href="{{ route('shopping.cart') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                お申し込みはこちらをクリック
            </a>
        </p>
        <hr class="my-6 border-t-1 border-gray-300">
        <p class="mt-3 text-xl font-semibold text-green-600">お召し上がり方</p>
        <p class="mt-4 mb-4">
            お召し上がり方健康食品として、1日10粒程度を目安にお水またはお湯など<br>
            でお召し上がり下さい。<br><br>

            ※噛んで食べると吸収がより早くなります。<br><br>

            ※魚アレルギーをお持ちの方はごくまれに湿疹が出る場合もあります。<br><br>

            専門医または弊社お客様相談窓口までご相談下さい。<br><br>

            ※お薬(処方薬・市販薬・漢方薬など)を服用されている方も安心して<br>
            お召し上がり下さい。<br><br>

            ※小さなお子様や飲み込む力の弱い方がお召し上がりになる際は、<br>
            数粒を一度に飲み込まないで1粒ずつお水またはお湯などで<br>
            ゆっくりお召し上がり下さい。<br><br>

            ◎ご家族が揃って、毎日を健康で安心した生活を、お送りいただくため<br>
            の海からのプレゼント「スクアラミン プルミエ」をぜひ、お試し下さい。
        </p>
        <p class="mousikomi mt-2 mb-8">
            <a href="{{ route('shopping.cart') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                お申し込みはこちらをクリック
            </a>
        </p>

        <hr class="my-6 border-t-1 border-gray-300">
        <div class="flex justify-center">
            <a href="{{ route('bio') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
                前へ戻る
            </a>
            <a href="#" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md mr-8">
                ページトップに戻る
            </a>
            <a href="{{ route('qa') }}" class="inline-flex items-center bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 px-5 rounded-md">
                次に進む
            </a>
        </div>
    </div>
</div>
@endsection
