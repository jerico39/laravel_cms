<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>

<header>
    <h1>株式会社サンプル</h1>
    <nav>
        <a href="/">TOP</a>
        <a href="/about">会社概要</a>
        <a href="/service">事業内容</a>
        <a href="/contact">お問い合わせ</a>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer>
    <p>© 2026 株式会社サンプル</p>
</footer>

</body>
</html>