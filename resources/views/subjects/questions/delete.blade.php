@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Delete Question</h1>
    </div>

    <form method="POST" action="{{ route('subjects.questions.destroy', [$subject, $question]) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p>Are you sure you want to permanently delete &quot;{{ $question->title }}&quot;?</p>
        <a href="{{ route('subjects.questions.index', [$subject]) }}" class="btn btn-default">Cancel</a>
        <button type="submit" class="btn btn-danger">Destroy Question</button>
    </form>
</div>
@endsection
