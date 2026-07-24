<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容確認</title>
</head>
<body>
    <h1>登録内容確認</h1>

    <p><strong>名前:</strong> {{ $validated['name'] }}</p>
    <p><strong>メールアドレス:</strong> {{ $validated['email'] }}</p>
    <p><strong>パスワード:</strong> ********</p>

    <form method="POST" action="{{ route('member.register.complete.post') }}">
        @csrf
        <input type="hidden" name="name" value="{{ $validated['name'] }}">
        <input type="hidden" name="email" value="{{ $validated['email'] }}">
        <input type="hidden" name="password" value="{{ $validated['password'] }}">
        <input type="hidden" name="password_confirmation" value="{{ $validated['password_confirmation'] ?? $validated['password'] }}">
        <button type="submit">登録</button>
    </form>
</body>
</html>
