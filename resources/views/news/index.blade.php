@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">ニュース一覧</h1>

    @if($newsList->count() > 0)
        <div class="grid gap-6">
            @foreach($newsList as $news)
                <article class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('news.show', $news->slug) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $news->title }}
                        </a>
                    </h2>
                    <div class="text-sm text-gray-500">
                        公開日: {{ $news->published_at->format('Y年m月d日') }}
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $newsList->links() }}
        </div>
    @else
        <p class="text-gray-600">ニュースがありません。</p>
    @endif
</div>
@endsection