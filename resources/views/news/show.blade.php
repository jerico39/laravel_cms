<h1>{{ $news->title }}</h1>

<p>{{ $news->published_at->format('Y-m-d') }}</p>

@if($news->image)
    <img src="{{ asset('storage/' . $news->image) }}" width="400">
@endif

<div>
    {!! $news->content !!}
</div>