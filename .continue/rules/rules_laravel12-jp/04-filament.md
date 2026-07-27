# Filament ルール

## 基本

Filamentの既存バージョンを確認してから実装する。

FilamentのバージョンによってAPIやメソッドが異なるため、現在のプロジェクトの実装を優先する。

## Resource

Resourceを作成または変更する場合は、以下を確認する。

- Model
- Migration
- Fillable / Guarded
- Cast
- Relation
- Form
- Table
- Filter
- Action

## Form

フォームの入力値は、DBカラムおよびModelの構造と一致させる。

Repeaterを使用する場合は、Repeater内部のデータ構造を確認する。

## Table

大量データを扱う場合は、不要なカラムやリレーションを過剰に読み込まない。

## FileUpload

ファイルアップロードを実装する場合は、以下を確認する。

- disk
- directory
- visibility
- storage:link
- filesystem設定
- 保存されるDB値
- 実際のURL生成方法

## Relation

RelationManagerを使用するか、Resource内でRepeaterを使用するかは、既存プロジェクトの設計に合わせる。

## 破壊的変更

Filamentの既存Resourceを大きく変更する場合、現在動作しているFormやTableを壊さないようにする。

変更対象を明確にする。
