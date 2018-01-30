@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="active">Subjects</li>
    </ol>

    <div class="page-header">
        <div class="pull-right">
            <a href="{{ route('subjects.create') }}" class="btn btn-default">Create Subject</a>
        </div>
        <h1>Subjects</h1>
    </div>

    <table class="table table-hover">
    @forelse ($subjects as $subject)
        <tr>
            <td><a href="{{ route('subjects.show', [$subject]) }}">{{ $subject->title }}</a></td>
            <td width="10%">
                <div class="btn-group" role="group">
                    <a href="{{ route('subjects.edit', [$subject]) }}" class="btn btn-primary btn-xs">Edit</a>
                    <a href="{{ route('subjects.delete', [$subject]) }}" class="btn btn-danger btn-xs">Delete</a>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td>No subjects</td>
        </tr>
    @endforelse
    </table>
</div>
@endsection
