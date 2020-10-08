# TCGMemo

欲しいカードをメモできるWebアプリになります。

# 使用ライブラリ

* laravel 7.28.3
* vue.js 2.6.12
* vue-router 3.4.5
* vuetify 2.3.10

# Installation

DBとの疎通ができている状態であれば、下記コマンドを順に打っていけば実行できるようになるはずです。。

```bash
php artisan migrate
php artisan db:seed
php artisan serve

npm install
npm run dev
```

# 使用法

1. フォルダー一覧から、フォルダーを追加します。
1. 追加したフォルダー名をクリックし、フォルダー内のカード一覧ページに遷移します。
1. カード一覧ページから欲しいカードを追加できます。

ホームのカード一覧はフォルダーに限らず、登録されているカード全てが1画面で確認できるようになっています。

```bash
php artisan serve
npm run dev
```

# 改善点

* ユーザー認証機能

ユーザー認証機能については、Laravelのmake:authでベースだけは作っているのですが時間がかかりそうだったので後回しに…

いずれ実装予定です。

* UI


# Author

* 作成者 LeekFoo