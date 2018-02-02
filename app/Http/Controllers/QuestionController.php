<?php

namespace App\Http\Controllers;

use App\Question;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function index(Subject $subject)
    {
        $this->authorize('view', $subject);
        return view('subjects.questions.index', compact('subject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function create(Subject $subject)
    {
        $this->authorize('update', $subject);
        $this->authorize('create', Question::class);

        return view('subjects.questions.create', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);
        $this->authorize('create', Question::class);

        $question = new Question;

        $question->user()->associate(Auth::user());
        $question->subject()->associate($subject);
        $question->title = $request->title;
        $question->answer = $request->answer;
        $question->notes = $request->notes ?? '';
        $question->n = 1;
        $question->ef = 2.5;
        $question->i = $question->calculateI($question->n);
        $question->next = $question->calculateNext($question->i);

        $question->save();

        return redirect()->route('subjects.questions.index', compact('subject'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject, Question $question)
    {
        $this->authorize('view', $subject);
        $this->authorize('view', $question);

        return view('subjects.questions.show', compact('subject', 'question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject, Question $question)
    {
        $this->authorize('update', $subject);
        $this->authorize('update', $question);

        return view('subjects.questions.edit', compact('subject', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject, Question $question)
    {
        $this->authorize('update', $subject);
        $this->authorize('update', $question);

        $question->title = $request->title;
        $question->answer = $request->answer;
        $question->notes = $request->notes ?? '';

        $question->save();

        return redirect()->route('subjects.questions.index', ['subject' => $subject]);
    }

    /**
     * Show the form for deleting a resource.
     *
     * @param  \App\Subject  $subject
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function delete(Subject $subject, Question $question)
    {
        $this->authorize('update', $subject);
        $this->authorize('delete', $question);

        return view('subjects.questions.delete', compact('subject', 'question'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject, Question $question)
    {
        $this->authorize('update', $subject);
        $this->authorize('delete', $question);

        $question->delete();

        return redirect()->route('subjects.questions.index', ['subject' => $subject]);
    }
}
