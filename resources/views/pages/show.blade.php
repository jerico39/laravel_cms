@extends('layouts.app')

@section('title', $page->title)



@section('content')
    <h2>{{ $page->title }}</h2>
@if($page->image)
    <img src="{{ asset('storage/' . $page->image) }}"
         alt="{{ $page->title }}"
         style="max-width: 100%; height: auto;">
@endif  
    <div>
        {!! $page->content !!}
    </div>
@endsection