


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
    <div style="color:green;">
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
                {{ $option->option_text }}
            </label>
        </div>
    @endforeach

    <hr>

    {{-- 新規 --}}
    <div>
        <label>
            <input type="radio" name="survey_option_id" value="new">
            <input type="text" name="new_option" value="{{ old('new_option') }}"
        placeholder="新しい選択肢"
        onfocus="this.closest('form').querySelector('input[value=new]').checked = true;">
        </label>
        @error('new_option')
            <div style="color:red;">
                {{ $message }}
            </div>
        @enderror
    </div>


    <textarea name="comment" class="border w-full mt-2">{{ old('comment') }}</textarea>

    <button type="submit">投票</button>
</form>


