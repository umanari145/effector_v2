# effector_v2


laravelインストーラー
```
composer global require laravel/installer
```

laravelプロジェクト作成
```
laravel new kourin
```

コンテナ内で下記を実装
```
/var/www/html# ~/.composer/vendor/laravel/installer/bin/laravel new kourin

   _                               _
  | |                             | |
  | |     __ _ _ __ __ ___   _____| |
  | |    / _` |  __/ _` \ \ / / _ \ |
  | |___| (_| | | | (_| |\ V /  __/ |
  |______\__,_|_|  \__,_| \_/ \___|_|


 ┌ Which starter kit would you like to install? ────────────────┐
 │ Livewire                                                     │
 └──────────────────────────────────────────────────────────────┘

 ┌ Which authentication provider do you prefer? ────────────────┐
 │ Laravel's built-in authentication                            │
 └──────────────────────────────────────────────────────────────┘

 ┌ Would you like to use Laravel Volt? ─────────────────────────┐
 │ Yes                                                          │
 └──────────────────────────────────────────────────────────────┘

 ┌ Which testing framework do you prefer? ──────────────────────┐
 │ PHPUnit                                                      │
 └──────────────────────────────────────────────────────────────┘
```

## livewire
laravelのSPA風のコンポーネントライブラリ<br>
https://zenn.dev/mabo/articles/71ada90a3f7948

## volt
PHPで使えるvueっぽい仕組み<br>
https://biz.addisteria.com/laravel-volt-livewire/

## 
## ClaudeCode
このPJでMCPサーバー+ClaudeCodeを使用。
<br>
claude-code

```
#npmインストール
npm install -g @anthropic-ai/claude-code 

added 2 packages in 3m

#インストール完了
claude --version
1.0.80 (Claude Code)
```

## migration データ投入
```
docker exec -it kourin-srv 
php artisan migrate
php artisan db:seed
```

## テスト実行
```
docker exec -it kourin-srv bash
./vendor/bin/phpunit ./test
```

submit
service/resources/views/contact/confirm.blade.phpの[送信する」
service/resources/views/livewire/shopping/order.blade.phpの「注文を確定する」
を押下した際にローディングするような処理をいれてください。



    const loadingSpinner = document.getElementById('loadingSpinner');
    const orderButton = document.getElementById('orderButton');
    const ordertext = document.getElementById('orderText');
    orderButton.addEventListener('mouseover', function() {
        orderButton.disabled = true;
        ordertext.innerText= '送信中...';
        loadingSpinner.classList.remove('hidden');
    });
