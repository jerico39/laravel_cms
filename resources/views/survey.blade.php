@extends('layouts.app')

@section('content')
<h1>{{ $survey->title }}</h1>

@if($survey->description)
    <p>{{ $survey->description }}</p>
@endif
    @if (session('error'))
        <div style="color:red;">
            {{ session('error') }}
        </div>
    @endif
    @if (session('msg'))
        <div style="color:green;font-weight:bold;">
            {{ session('msg') }}
        </div>
    @endif
<form method="POST" action="/survey/vote">
    @csrf


    <input type="hidden" name="survey_id" value="{{ $survey->id }}">

    {{-- 既存 --}}
    @foreach($survey->options as $option)
        <div>
            <label>
                <input type="radio" name="survey_option_id" value="{{ $option->id }}">
                {{ $option->option_text }}@if($option->is_user_generated) [追加]@endif
            </label>
        </div>
    @endforeach

    <hr>

    {{-- 新規 --}}
    <div>
        <label>
            <input type="radio" name="survey_option_id" value="new">
            <input type="text" name="new_option" value="{{ old('new_option') }}" placeholder="新しい選択肢"  onfocus="this.closest('form').querySelector('input[value=new]').checked = true;">
        </label>
        @error('new_option')
            <div style="color:red;">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div>
        <h3>コメント</h3>
        @error('comment')
            <div style="color:red;">
                {{ $message }}
            </div>
        @enderror
        <p>投票に関するご意見をお書きください(任意:200文字以内)</p><div id="count" class="text-right text-sm text-gray-500">0 / 200</div>
        <textarea name="comment" class="border w-full mt-2">{{ old('comment') }}</textarea>
<script>
const textarea = document.querySelector('textarea[name="comment"]');
const counter = document.getElementById('count');

textarea.addEventListener('input', () => {
    counter.textContent = textarea.value.length + ' / 200';
});
</script>
        
    </div>
    <div>
        <button type="submit">投票する</button>
    </div>
</form>
@endsection

