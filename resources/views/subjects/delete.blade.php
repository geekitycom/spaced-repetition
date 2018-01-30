@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Delete Subject</h1>
    </div>

    <form method="POST" action="{{ route('subjects.destroy', [$subject]) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <p>Are you sure you want to permanently delete &quot;{{ $subject->title }}&quot;?</p>
        <a href="{{ route('subjects.index') }}" class="btn btn-default">Cancel</a>
        <button type="submit" class="btn btn-danger">Destroy Subject</button>
    </form>
</div>
@endsection
