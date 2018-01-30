@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Create Question</h1>
    </div>

    <form method="POST" action="{{ route('subjects.questions.store', [$subject]) }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Question</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="answer">Answer</label>
            <textarea class="form-control" rows="3" id="answer" name="answer"></textarea>
        </div>
        <div class="form-group">
            <label for="notes">Notes (optional)</label>
            <textarea class="form-control" rows="10" id="notes" name="notes"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Store Question</button>
    </form>
</div>
@endsection
