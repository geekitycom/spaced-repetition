@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
      <h1>Great Job!</h1>
      <p>You've completed all questions for today.</p>
      <p><a class="btn btn-primary btn-lg" href="{{ route('home') }}" role="button">Done</a></p>
    </div>
</div>
@endsection
