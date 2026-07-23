# Laravel + Filament プロジェクト全体解析

VS Codeで開かれているWorkspace全体を対象に解析する。

## 目的

Laravel + Filamentアプリケーションの全体構造を把握する。

## 実行手順

1. composer.jsonを確認
2. LaravelとFilamentのバージョンを確認
3. app/以下の構成を確認
4. Modelを確認
5. Migrationを確認
6. Resourceを確認
7. Pageを確認
8. RelationManagerを確認
9. Policyを確認
10. Routeを確認
11. Service / Actionを確認
12. testsを確認

## 出力

### 1. 技術構成

- Laravel
- PHP
- Filament
- Database
- Frontend
- Authentication
- Authorization

### 2. ディレクトリ構成

各ディレクトリの責務を説明する。

### 3. ドメインモデル

ModelとRelationshipを一覧化する。

### 4. Filament構成

Resource、Page、RelationManagerを整理する。

### 5. データフロー

画面操作からDB保存までの流れを説明する。

### 6. 重要な設計上の注意点

### 7. 技術的負債

事実と推測を分けて記載する。
