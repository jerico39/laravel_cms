# Workspace Rules

Workspaceを解析する際は以下のディレクトリを対象外とすること。

- vendor/
- node_modules/
- storage/
- bootstrap/cache/
- public/storage/
- public/build/
- .git/

これらは生成物または外部ライブラリであり、
コードレビュー・設計・バグ解析対象に含めない。

アプリケーションコードのみを解析すること。

対象

app/
routes/
config/
database/
resources/
tests/