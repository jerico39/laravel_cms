# Laravel + Filament セキュリティレビュー

指定された機能をセキュリティレビューする。

## 確認

- Authentication
- Authorization
- Policy
- Gate
- Role
- Permission
- Mass Assignment
- CSRF
- XSS
- SQL Injection
- File Upload
- Path Traversal
- IDOR
- Race Condition

## 出力

| 重要度 | 問題 | 根拠 | 影響 | 改善案 |
|---|---|---|---|---|

重要度:

- Critical
- High
- Medium
- Low

実際にコードから確認できた問題と、可能性の指摘を分ける。
