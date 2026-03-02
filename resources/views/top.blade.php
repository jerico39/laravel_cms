<h2>Latest News</h2>

@foreach($news as $item)
    <div style="margin-bottom:20px;">
        <h3>{{ $item->title }}</h3>

        @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}"
                 style="max-width:200px;">
        @endif

        <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
    </div>
@endforeach