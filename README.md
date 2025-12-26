# タスケテ 〜HELP ME!!〜

当日券特化型予約サービス

## 概要

「タスケテ 〜HELP ME!!〜」は、演劇の当日券情報を簡単に見つけられる予約サービスです。

- **エンドユーザー**: 今日以降の公演情報・当日券の有無を確認
- **劇団管理者**: 自劇団の公演情報を管理
- **システム管理者**: 全劇団・公演を統括管理

## 技術スタック

### バックエンド
- Laravel 11.x
- MySQL 8.x
- Laravel Sanctum（認証）

### フロントエンド
- Vue 3（Composition API）
- Inertia.js
- Tailwind CSS 4
- PrimeVue 4（管理画面）

## ドキュメント

詳細な仕様は `docs/` ディレクトリを参照してください：

- [01_database_schema.md](docs/01_database_schema.md) - データベース設計
- [02_features.md](docs/02_features.md) - 機能仕様
- [03_routes_and_api.md](docs/03_routes_and_api.md) - ルーティング・API仕様

## セットアップ

### 1. 依存関係のインストール

```bash
# Composerパッケージ
composer install

# Node.jsパッケージ
npm install
```

### 2. 環境設定

```bash
# .envファイルを作成
cp .env.example .env

# アプリケーションキーを生成
php artisan key:generate
```

### 3. データベース設定

`.env` ファイルでデータベース接続情報を設定：

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasukete
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. マイグレーション実行

```bash
php artisan migrate
```

### 5. シンボリックリンク作成

```bash
php artisan storage:link
```

## 開発サーバー起動

### 方法1: 開発モード（推奨）

ターミナル1:
```bash
npm run dev
```

ターミナル2:
```bash
php artisan serve
```

ブラウザで http://127.0.0.1:8000 にアクセス

### 方法2: 本番ビルド

```bash
npm run build
php artisan serve
```

## プロジェクト構成

```
tasukete-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # 管理画面コントローラー
│   │   │   └── Auth/           # 認証コントローラー
│   │   └── Middleware/
│   │       └── HandleInertiaRequests.php
│   ├── Models/
│   │   ├── Troupe.php          # 劇団モデル
│   │   ├── Performance.php     # 公演モデル
│   │   └── AdminUser.php       # 管理者モデル
│   └── Policies/               # 認可ポリシー
├── resources/
│   ├── js/
│   │   ├── Layouts/
│   │   │   ├── DashboardLayout.vue  # 管理画面レイアウト
│   │   │   └── GuestLayout.vue      # 公開ページレイアウト
│   │   └── Pages/
│   │       ├── Welcome.vue          # トップページ
│   │       └── Dashboard.vue        # ダッシュボード
│   ├── css/
│   │   └── app.css
│   └── views/
│       └── app.blade.php       # Inertiaルートテンプレート
├── routes/
│   └── web.php                 # ルート定義
├── docs/                       # 仕様書
└── README.md
```

## 開発方針

### PRルール
- 1PR = 1つの意思決定
- 200行以内を目安
- mainへの直プッシュ禁止、PR必須

### ブランチ戦略
- `main`: 本番環境
- `feature/*`: 機能開発

## ライセンス

MIT License

## 関連リンク

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [PrimeVue Documentation](https://primevue.org/)
