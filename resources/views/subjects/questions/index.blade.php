@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{ route('subjects.index') }}">Subjects</a></li>
        <li class="active">{{ $subject->title }}</li>
    </ol>

    <div class="page-header">
        <div class="pull-right">
            <a href="{{ route('subjects.questions.create', [$subject]) }}" class="btn btn-default">Create Question</a>
        </div>
        <h1>{{ $subject->title }}</h1>
    </div>

    <table class="table table-hover">
    @forelse ($subject->questions as $question)
        <tr>
            <td><a href="{{ route('subjects.questions.show', [$subject, $question]) }}">{{ $question->title }}</a></td>
            <td width="10%">
                <div class="btn-group" role="group">
                    <a href="{{ route('subjects.questions.edit', [$subject, $question]) }}" class="btn btn-primary btn-xs">Edit</a>
                    <a href="{{ route('subjects.questions.delete', [$subject, $question]) }}" class="btn btn-danger btn-xs">Delete</a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td>No questions</td>
        </tr>
    @endforelse
    </table>
</div>
@endsection
