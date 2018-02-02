<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Auth::user()->subjects;

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Subject::class);

        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Subject::class);

        $subject = new Subject;

        $subject->user()->associate(Auth::user());
        $subject->title = $request->title;

        $subject->save();

        return redirect()->route('subjects.show', ['subject' => $subject]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);

        return redirect()->route('subjects.questions.index', ['subject' => $subject]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);

        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $subject->title = $request->title;

        $subject->save();

        return redirect()->route('subjects.index');
    }

    /**
     * Show the form for deleting a resource.
     *
     * @param  \App\Subject  $subject
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function delete(Subject $subject)
    {
        $this->authorize('delete', $subject);

        return view('subjects.delete', compact('subject'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        $subject->delete();

        return redirect()->route('subjects.index');
    }
}
