<?php

use Illuminate\Support\Facades\Route;

use App\Models\Page;

Route::get('/', function () {
    $page = Page::where('slug', 'home')
        ->where('is_published', true)
        ->firstOrFail();

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