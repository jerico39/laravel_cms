@php
$menu = \App\Models\Menu::where('slug', 'header')->first();
@endphp

@if($menu)
<ul>
@foreach($menu->items as $item)

<li>
<a href="{{ url($item->url) }}">
{{ $item->title }}
</a>
</li>

@endforeach
</ul>
@endif