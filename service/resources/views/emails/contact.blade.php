<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ確認メール</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>お問い合わせを受け付けました</h2>

    <p>{{ $data['name'] }}様</p>

    <p>この度はお問い合わせいただき、ありがとうございます。<br>
    以下の内容でお問い合わせを受け付けました。</p>

    <hr>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px; background-color: #f5f5f5; font-weight: bold; width: 30%;">お名前</td>
            <td style="padding: 8px;">{{ $data['name'] }}</td>
        </tr>
        @if(!empty($data['tel']))
        <tr>
            <td style="padding: 8px; background-color: #f5f5f5; font-weight: bold;">電話番号</td>
            <td style="padding: 8px;">{{ $data['tel'] }}</td>
        </tr>
        @endif
        <tr>
            <td style="padding: 8px; background-color: #f5f5f5; font-weight: bold;">メールアドレス</td>
            <td style="padding: 8px;">{{ $data['email1'] }}</td>
        </tr>
        @if(!empty($data['zip']))
        <tr>
            <td style="padding: 8px; background-color: #f5f5f5; font-weight: bold;">郵便番号</td>
            <td style="padding: 8px;">{{ $data['zip'] }}</td>
        </tr>
        @endif
        <tr>
            <td style="padding: 8px; background-color: #f5f5f5; font-weight: bold;">住所</td>
            <td style="padding: 8px;">{{ $data['address'] }}</td>
        </tr>
    </table>

    <hr>

    <p>内容を確認の上、担当者よりご連絡させていただきます。<br>
    しばらくお待ちください。</p>

    <p>このメールは自動送信です。返信はできません。</p>

    <p>----<br>
    光輪コーポレーション有限会社<br>
    〒000-0000 千葉県船橋市薬円台3-16-5 ハートフィールズ薬園台ハイライズ606<br>
    TEL: 080-4400-5013<br>
    EMAIL: ec@kourin.lolipop.jp<br>
    ----</p>
</body>
</html>
