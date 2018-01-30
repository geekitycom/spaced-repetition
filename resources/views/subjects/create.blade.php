@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Create Subject</h1>
    </div>

    <form method="POST" action="{{ route('subjects.store') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <button type="submit" class="btn btn-primary">Store Subject</button>
    </form>
</div>
@endsection
