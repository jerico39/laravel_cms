@extends('layouts.app')

@section('title', $page->title)

@section('content')

<h1>{{ $page->title }}</h1>

{{-- 画像 --}}
@if(!empty($page->image))
    <div class="page-image">
        <img src="{{ asset('storage/'.$page->image) }}"
             alt="{{ $page->title }}"
             style="max-width:100%; height:auto;">
    </div>
@endif


{{-- 作成日 --}}
@if(!empty($page->created_at))
<p class="page-date">
    {{ \Carbon\Carbon::parse($page->created_at)->format('Y-m-d') }}
</p>
@endif


{{-- 本文 --}}
<div class="page-content">
    {!! $page->content !!}
</div>


{{-- 関連ページ --}}
@if(isset($pageList) && $pageList->count())
<section class="page-area">

<h2>Other Pages</h2>

@foreach($pageList as $item)
<div class="page-item">

    <a href="{{ route('page.show', $item->slug) }}">
        {{ $item->title }}
    </a>

    @if(!empty($item->created_at))
    <p>
        {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
    </p>
    @endif

</div>
@endforeach

</section>
@endif

@endsection