# Laravel + Filament Code Review

変更されたコードをレビューする。

## レビュー項目

### 機能

- 要件を満たしているか
- 既存機能を壊していないか

### Laravel

- 責務分離
- Validation
- Authorization
- Transaction
- Exception Handling

### Filament

- Resource
- Form
- Table
- Action
- Relationship
- Livewire State

### Database

- NULL
- Unique
- Foreign Key
- Index
- Race Condition

### Security

- Mass Assignment
- IDOR
- File Upload
- XSS
- SQL Injection

## 出力

問題があるものだけを以下の形式で出力する。

### [Critical / High / Medium / Low]

- ファイル:
- 行:
- 問題:
- 根拠:
- 影響:
- 修正案:

問題がない場合は「重大な問題は確認できない」と明示する。
