@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Edit Question</h1>
    </div>

    <form method="POST" action="{{ route('subjects.questions.update', [$subject, $question]) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label for="title">Question</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $question->title }}">
        </div>
        <div class="form-group">
            <label for="answer">Answer</label>
            <textarea class="form-control" rows="3" id="answer" name="answer">{{ $question->answer }}</textarea>
        </div>
        <div class="form-group">
            <label for="notes">Notes (optional)</label>
            <textarea class="form-control" rows="10" id="notes" name="notes">{{ $question->notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
</div>
@endsection
