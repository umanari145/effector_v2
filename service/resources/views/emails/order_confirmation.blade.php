<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ご注文ありがとうございました</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #22c55e;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .section h3 {
            color: #22c55e;
            margin-top: 0;
            border-bottom: 2px solid #22c55e;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        .total-row {
            background-color: #22c55e;
            color: white;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ご注文ありがとうございました</h1>
        <p>注文ID: {{ $cart->id }}</p>
    </div>

    <div class="section">
        <h3>ご注文内容</h3>
        <table>
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>単価</th>
                    <th>数量</th>
                    <th>小計</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>¥{{ number_format($item['unit_price']) }}</td>
                    <td>{{ $item['quantity'] }}個</td>
                    <td>¥{{ number_format($item['price']) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">合計金額</td>
                    <td>¥{{ number_format($cart->total_price) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>お客様情報</h3>
        <table>
            <tr>
                <th style="width: 30%;">お名前</th>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <th>お名前（カナ）</th>
                <td>{{ $customer->kana }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $customer->tel }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>{{ $customer->zip }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>
                    {{ $customer->prefecture }} {{ $customer->city }}<br>
                    {{ $customer->address }}
                    @if($customer->building)
                        <br>{{ $customer->building }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>配送先情報</h3>
        <table>
            <tr>
                <th style="width: 30%;">お名前</th>
                <td>{{ $cart->shipping->shipping_name }}</td>
            </tr>
            <tr>
                <th>お名前（カナ）</th>
                <td>{{ $cart->shipping->shipping_kana }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $cart->shipping->shipping_tel }}</td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>{{ $cart->shipping->shipping_zip }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>
                    {{ $cart->shipping->shipping_prefecture }} {{ $cart->shipping->shipping_city }}<br>
                    {{ $cart->shipping->shipping_address }}
                    @if($cart->shipping->shipping_building)
                        <br>{{ $cart->shipping->shipping_building }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>この度はご注文いただき、誠にありがとうございました。</p>
        <p>商品の発送準備が整い次第、改めてご連絡させていただきます。</p>
        <p>ご不明な点がございましたら、お気軽にお問い合わせください。</p>
    </div>
</body>
</html>