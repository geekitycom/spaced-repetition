@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
      <h1>{{ $question->subject->title }}</h1>
      <p>{{ $question->title }}</p>
      <p><a class="btn btn-primary btn-lg" href="{{ route('review.answer', [$question]) }}" role="button">Show Answer</a></p>
    </div>
</div>
@endsection
