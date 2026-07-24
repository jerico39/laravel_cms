<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
</head>
<body>
    <h1>登録完了</h1>

    @if ($member)
        <p>会員登録が完了しました。</p>
        <p>名前: {{ $member->name }}</p>
        <p>メールアドレス: {{ $member->email }}</p>
    @else
        <p>登録情報が見つかりませんでした。</p>
    @endif
</body>
</html>
