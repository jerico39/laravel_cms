# プロジェクトの構造ルール

AIエージェントはコードを探索・変更する際、以下のディレクトリ構成を前提にしてください。

## ルート構成
- `app/`: アプリケーションのビジネスロジック、モデル、コントローラ、サービス、プロバイダなど
- `bootstrap/`: フレームワーク初期化用の設定ファイル
- `config/`: アプリケーション設定ファイル
- `database/`: マイグレーション、シーダー、ファクトリ
- `lang/`: 多言語メッセージ定義
- `public/`: 公開用の静的ファイルとエントリポイント
- `resources/`: ビュー、CSS、JavaScript、Bladeテンプレート
- `routes/`: Web/API/コンソールルート定義
- `storage/`: 実行時生成ファイル、キャッシュ、ログ
- `tests/`: テストコード
- `vendor/`: Composer依存関係

## 主要ディレクトリの役割
- `app/Http/`: HTTPリクエスト処理、コントローラ、ミドルウェア
- `app/Models/`: Eloquentモデル定義
- `app/Providers/`: サービスプロバイダ、DI登録、初期化処理
- `app/Filament/`: Filament管理画面のリソース、ページ、設定
- `app/Livewire/`: Livewireコンポーネント
- `app/Helpers/`: 共通ヘルパー関数
- `database/migrations/`: DBスキーマ変更履歴
- `database/seeders/`: 初期データ投入
- `resources/views/`: Bladeテンプレート
- `resources/css/` と `resources/js/`: フロントエンド資産
- `routes/web.php`: Web画面ルート
- `routes/console.php`: Artisanコマンド定義

## 実装時の注意
- 認証・認可周りは `app/Http/`、`app/Providers/`、`app/Models/` の関連箇所を確認してください。
- データベース変更は `database/migrations/` と関連モデルを合わせて確認してください。
- 画面変更は `resources/views/` と `app/Filament/`、`app/Livewire/` を優先して確認してください。
- ルート追加・変更は `routes/` 配下の該当ファイルを確認してください。
- 新規ファイルを追加する場合は、既存のディレクトリ構成と命名規則に合わせて配置してください。
- 変更内容がどの層に属するかを意識し、責務ごとに適切なディレクトリへ実装してください。
