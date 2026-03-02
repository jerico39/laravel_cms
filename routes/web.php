<?php

use Illuminate\Support\Facades\Route;

use App\Models\Page;
use App\Models\News;

Route::get('/', function () {
    $page = Page::where('slug', 'home')
        ->where('is_published', true)
        ->firstOrFail();
    $newsList = News::published()
        ->latest('published_at')
        ->take(5)
        ->get();

    return view('pages.show', compact('page', 'newsList'));
});

#Route::get('/', function () {
#    return view('welcome');
#});

//ニュースの詳細ページ
Route::get('/news/{slug}', function ($slug) {

    $news = News::published()
        ->where('slug', $slug)
        ->firstOrFail();

    return view('news.show', compact('news'));

})->name('news.show');


Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('pages.show', compact('page'));
});