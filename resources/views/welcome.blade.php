@extends('layouts.app')

@section('body')
<body class="homepage">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6">
            <div class="page-header">
                <h1>Welcome to Learn!</h1>
            </div>

            <p>Learn is a spaced repetition learning tool based on the <a href="https://www.supermemo.com/english/ol/sm2.htm">SM-2 algorithm</a>.</p>

            <p>This website is a very rough prototype at this point. If there proves to be any interest in it I may spend some time spiffing it up.  Otherwise, it's just here to scratch my own itch.</p>

            <p>Using Learn should be very simple.  When you log in you can create a new "Subject" this can be a school subject like English or Math, or it could just be the subject of your questions like the title of a book you're reading.</p>

            <p>Once you create a subject you can add questions.  There are three fields for questions.  The question you're asking, the answer and optionally some notes for reference.</p>

            <p>Once you've created a bunch of questions, you can "Review" your questions by clicking on "Review" in the nav bar.  If there are any questions scheduled to be reviewed that day you'll be asked them one at a time.</p>

            <p>This program doesn't grade you automatically, but rather you look at the question, click to see the answer and score yourself one of six scores (0-5).  There are descriptions of what each score means.</p>

            <p>Based on when you reviewed the question last and what your score was, the system will automatically figure out when you should review the question next.</p>

            <p>If you don't answer the question correctly or have a hard time answering it (a score less than 4) you'll be asked the question again during the current review session until you score at least a 4.</p>

            <p>This application is open source and is available on <a href="https://github.com/geekitycom/spaced-repetition">GitHub</a>. If you have any questions, either <a href="https://github.com/geekitycom/spaced-repetition/issues">submit an issue on GitHub</a> or <a href="https://blog.andrewshell.org/contact-andrew/">contact me</a>.</p>
        </div>
    </div>
</div>
@endsection
