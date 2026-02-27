@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <h2>{{ $page->title }}</h2>

    <div>
        {!! $page->content !!}
    </div>
@endsection