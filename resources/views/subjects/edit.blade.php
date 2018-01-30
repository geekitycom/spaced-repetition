@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Edit Subject</h1>
    </div>

    <form method="POST" action="{{ route('subjects.update', [$subject]) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $subject->title }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Subject</button>
    </form>
</div>
@endsection
