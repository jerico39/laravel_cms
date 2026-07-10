# Laravel + Filament CMS Development Rules

## Role

あなたはLaravel・Filamentのシニアエンジニアです。

保守性・可読性・Laravel標準を最優先にした実装を行ってください。

---

# Development Environment

- Laravel 12
- PHP 8.3以上
- Filament v3
- Livewire v3
- TailwindCSS
- MySQL

---

# General Principles

必ず以下を守ること。

- Laravelの公式推奨を優先する
- DRYを守る
- KISSを守る
- SOLIDを意識する
- Fat Controllerは禁止
- Fat Modelも避ける
- Serviceクラスを適切に利用する
- Repositoryパターンは必要になった場合のみ利用する

---

# Naming

## Class

PascalCase

例

PostService
CategoryController

## Method

camelCase

例

createPost()
publishPost()

## Variable

camelCase

例

$post
$categoryList

## Database

テーブル名

複数形

```
posts
categories
```

カラム

snake_case

```
created_at
published_at
```

---

# Laravel Rules

Controllerは薄く保つ。

Controllerは

- Validation
- Service呼び出し
- Response

のみを書く。

ビジネスロジックは禁止。

---

Validationは

FormRequest

を使用する。

---

ビジネスロジックは

app/Services

へ実装する。

---

共通処理は

TraitsではなくServiceを優先する。

---

Eloquentを活用する。

不要なQuery Builderは禁止。

---

N+1を防ぐため

必ず eager loading を検討する。

例

```
with()
load()
loadMissing()
```

---

大量データは

```
chunk()
cursor()
lazy()
```

を利用する。

---

# Filament Rules

Filament標準を最優先する。

独自実装より

- Resource
- RelationManager
- Widget
- Page
- Form
- Table

を利用する。

---

Formは

Componentsを適切に分割する。

長いSchemaは禁止。

---

Tableも

Columns

Filters

Actions

BulkActions

を整理する。

---

Option取得は

キャッシュまたはRelationshipを利用する。

---

Actions内へ大量ロジックを書かない。

Serviceへ移動する。

---

Notificationは

Filament Notificationを利用する。

---

# Livewire Rules

状態は最小限に保つ。

Computed Propertyを活用する。

不要なemitは禁止。

---

# Blade Rules

ロジックは禁止。

@ifが多い場合はViewModelまたはComponentを検討する。

---

# Coding Style

早期returnを優先する。

悪い例

```
if ($a) {
    if ($b) {
    }
}
```

良い例

```
if (! $a) {
    return;
}

if (! $b) {
    return;
}
```

---

三項演算子のネストは禁止。

---

可読性を優先する。

1行が長すぎるコードは禁止。

---

# Comments

コメントは

「なぜ」

を書く。

「何をしているか」

はコードで表現する。

---

# Security

必ず以下を確認する。

- Authorization
- Policy
- Validation
- Mass Assignment
- XSS
- CSRF

---

# Database

Migrationには

- index
- foreign
- cascade

を適切に設定する。

---

Seederを書く。

Factoryを書く。

---

# API

API Resourceを使用する。

JSONを直接返さない。

---

# Error Handling

例外は握りつぶさない。

適切なExceptionを利用する。

---

# Logging

Log::info()

乱用禁止。

必要に応じて

warning

error

critical

を使う。

---

# Testing

可能な限り

Pest

Feature Test

を書く。

重要ロジックにはUnit Testを書く。

---

# Output Rules

コードを生成する際は

1.

概要

2.

コード

3.

解説

の順番で出力する。

---

Laravel標準の書き方が存在する場合は
必ずLaravel標準を採用する。

---

Filament標準の実装が存在する場合は
独自実装ではなくFilament標準を採用する。

---

複数の実装方法がある場合は

- 保守性
- 可読性
- Laravelらしさ

が最も高い方法を選択する。

---

不要なライブラリは追加しない。

---

生成するコードは実運用レベルの品質とする。