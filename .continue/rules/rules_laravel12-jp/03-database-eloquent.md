# Database / Eloquent ルール

## DB構造確認

DB関連の実装を行う前に、以下を確認する。

- 対象Model
- Migration
- リレーション
- テーブル名
- カラム名
- インデックス
- 外部キー
- 既存のScope
- Cast設定

## Eloquent

既存のModelとリレーションを優先して使用する。

同じデータ取得処理を複数箇所に重複させない。

## N+1

リレーションをループ内で個別取得する実装を避ける。

必要に応じて以下を検討する。

- with()
- load()
- withCount()
- withExists()

## DBクエリ

大量データを扱う場合は、chunk()、chunkById()、lazy()、cursor()、paginate()を検討する。

## Migration

既存DBへの影響を考慮する。

既存カラムを変更する場合は、データ損失の可能性を確認する。

外部キーを追加する場合は、参照先テーブルが先に作成されることを確認する。

## SQL

Eloquentで十分な場合は、直接SQLを書かない。

Raw SQLを使用する場合はSQLインジェクションを防止する。
