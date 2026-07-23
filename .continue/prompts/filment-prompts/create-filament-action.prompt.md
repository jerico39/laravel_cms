# Filament Action作成

Filament Actionを作成または変更する。

## 必須確認

- 操作対象
- 現在の状態
- 実行条件
- 権限
- Validation
- DB変更
- Transaction
- 二重実行
- 失敗時処理

## 実装方針

単純なUI操作はAction内に記述してよい。

複雑な業務処理はServiceまたはActionクラスへ分離する。

状態遷移を伴う場合、現在の状態を確認してから処理する。
