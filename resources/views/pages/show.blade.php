@extends('layouts.app')

@section('title', $page->title)



@section('content')
    <h2>{{ $page->title }}</h2>
@if($page->image)
    <img src="{{ asset('storage/' . $page->image) }}"
         alt="{{ $page->title }}"
         style="max-width: 100%; height: auto;">
@endif  

@if(isset($newsList) && $newsList->count())
    <section class="news-area">
        <h2>NEWS</h2>

        @foreach($newsList as $news)
            <div class="news-item">
                <ul>
                    <li><p>{{ $news->published_at->format('Y-m-d') }}：{{ $news->title }}</p></li>
                </ul>
            </div>
        @endforeach
    </section>
@endif

    <div>
        {!! $page->content !!}
    </div>
@endsection