@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{ route('subjects.index') }}">Subjects</a></li>
        <li><a href="{{ route('subjects.questions.index', [$subject]) }}">{{ $subject->title }}</a></li>
        <li class="active">{{ $question->title }}</li>
    </ol>

    <div class="page-header">
        <h1>{{ $question->title }}</h1>
    </div>

    <dl class="dl-horizontal">
      <dt>Answer</dt><dd>{{ $question->answer }}</dd>
      <dt>Notes</dt><dd>{{ $question->notes }}</dd>
    </dl>
</div>
@endsection
