<?php

use Illuminate\Support\Facades\Route;

use App\Models\Page;
use App\Models\News;
use App\Http\Controllers\SurveyController;


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

//ニュース一覧ページ
Route::get('/news', function () {
    $newsList = News::published()
        ->latest('published_at')
        ->paginate(10);

    return view('news.index', compact('newsList'));
})->name('news.index');

//アンケートの詳細ページと投票処理
Route::get('/survey/{id}', [SurveyController::class, 'show']);
Route::post('/survey/vote', [SurveyController::class, 'vote']);

Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('pages.show', compact('page'));
});


