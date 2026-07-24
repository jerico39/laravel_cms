<?php

use Illuminate\Support\Facades\Route;

use App\Models\Page;
use App\Models\News;
use App\Http\Controllers\SurveyController;


use App\Http\Controllers\MemberRegisteredUserController;

Route::get('/member/register', [MemberRegisteredUserController::class, 'showRegistrationForm'])
    ->name('member.register');

Route::post('/member/register/confirm', [MemberRegisteredUserController::class, 'confirmRegistration'])
    ->name('member.register.confirm');

Route::post('/member/register/complete', [MemberRegisteredUserController::class, 'completeRegistration'])
    ->name('member.register.complete.post');

Route::get('/member/register/complete', [MemberRegisteredUserController::class, 'showCompletionPage'])
    ->name('member.register.complete');


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


//ニュースのプレビュー（管理者のみアクセス可能）
Route::get('/news/preview/{id}', function ($id) {
    $news = News::findOrFail($id);

    return view('news.show', compact('news'));
})->middleware('auth')->name('news.preview');



//ニュース一覧ページ
Route::get('/news', function () {
    $newsList = News::published()
        ->latest('published_at')
        ->paginate(10);

    return view('news.index', compact('newsList'));
})->name('news.index');

//アンケートの詳細ページと投票処理

// 先に具体ルート
Route::get('/survey/{id}', [SurveyController::class, 'show'])
    ->name('survey.show');

Route::post('/survey/vote', [SurveyController::class, 'vote']);

Route::get('/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('pages.show', compact('page'));
});

