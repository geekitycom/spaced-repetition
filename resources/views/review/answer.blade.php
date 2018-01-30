@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
      <h1>{{ $question->subject->title }}</h1>
      <p>{{ $question->title }}</p>
      <p>{{ $question->answer }}</p>
    </div>

    <form method="POST" action="{{ route('review.update', [$question]) }}">
        {{ csrf_field() }}

        @foreach ($options as $score => $desc)
        <div class="radio">
            <label>
                <input type="radio" name="score" id="score{{ $score }}" value="{{ $score }}">
                {{ $desc }}
            </label>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Score Question</button>
    </form>

    <p>{{ $question->notes }}</p>
</div>
@endsection
