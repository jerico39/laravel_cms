# Workspace分析時の除外対象

プロジェクト全体を分析する場合でも、以下のディレクトリは原則として分析対象から除外する。

## Laravel

- vendor/
- node_modules/
- storage/framework/
- storage/logs/
- bootstrap/cache/

## Git

- .git/
- .github/

## ビルド成果物

- public/build/
- public/hot/
- dist/
- build/

## キャッシュ

- .cache/
- .npm/
- .vite/

## 大容量データ

- storage/app/
- uploads/
- backup/
- backups/
- tmp/

## ルール

上記ディレクトリの内容を、通常のコード解析対象として扱わない。

ただし、ユーザーが明示的に特定のファイルやログを指定した場合は、そのファイルを分析する。

特に以下は必要に応じて参照する。

- storage/logs/laravel.log
- storage/app/特定ファイル
- public/uploads/特定ファイル
