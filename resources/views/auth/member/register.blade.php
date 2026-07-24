<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
</head>
<body>
    <h1>会員登録</h1>
    <form method="POST" action="{{ route('member.register.confirm') }}">
        @csrf
        <div>
            <label for="name">名前:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<div>{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<div>{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
            @error('password')<div>{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password_confirmation">パスワード確認:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')<div>{{ $message }}</div>@enderror
        </div>
        <button type="submit">確認画面へ</button>
    </form>
</body>
</html>