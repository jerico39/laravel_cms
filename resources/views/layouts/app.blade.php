@php
$setting = \App\Models\Setting::first();
@endphp
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $setting->site_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        nav a {
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

@include('layouts.header')

<main>
    @yield('content')
</main>

<footer>
    <p>© 2026 株式会社サンプル</p>
</footer>

</body>
</html>