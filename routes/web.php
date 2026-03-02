<?php

use Illuminate\Support\Facades\Route;

use App\Models\Page;
use App\Models\News;

Route::get('/', function () {
    $page = Page::where('slug', 'home')
        ->where('is_published', true)
        ->firstOrFail();

    $news = News::where('is_published', true)
    ->orderByDesc('published_at')
    ->take(5)
    ->get();

    return view('pages.show', compact('page'));
});

#Route::get('/', function () {
#    return view('welcome');
#});

Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('pages.show', compact('page'));
});