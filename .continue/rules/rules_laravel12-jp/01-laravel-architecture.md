# Laravel アーキテクチャルール

## 基本

Laravelの標準的な責務分離を優先する。

基本的な責務は以下の通り。

- Route: URLとControllerの接続
- Controller: HTTPリクエストの受付とレスポンス制御
- FormRequest: 入力値のバリデーション
- Service: 複数の業務処理をまとめる
- Model: データとドメインロジック
- Repository: 複雑なデータ取得処理が必要な場合のみ使用
- Resource: APIレスポンスの整形
- Job: 非同期処理
- Event / Listener: 疎結合なイベント処理

## Controller

Controllerに複雑な業務ロジックを直接記述しない。

以下のような処理はServiceまたは適切なクラスへ分離する。

- 複数テーブルへの登録
- 複雑な条件分岐
- 外部API連携
- メール送信
- 決済処理
- ファイル処理
- トランザクション処理

## バリデーション

Controller内で直接バリデーションするより、複雑な場合はFormRequestを使用する。

入力値は信頼せず、必ずバリデーションする。

## トランザクション

複数のDB更新が1つの処理単位となる場合は、DBトランザクションを検討する。

## Laravel標準機能

独自実装よりも、以下のLaravel標準機能を優先する。

- Eloquent
- FormRequest
- Validation
- Policies
- Gates
- Events
- Jobs
- Notifications
- Mail
- Cache
- Queue
- Storage
- HTTP Client
