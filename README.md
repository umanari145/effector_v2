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