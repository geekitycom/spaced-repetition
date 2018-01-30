<?php

namespace App\Http\Controllers;

use App\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Get list of items for day, will then process list over and over
        //       removing items only when they score a 4 or 5.

        if (isset($_GET['day']) && preg_match('!^\d{4}-\d{2}-\d{2}$!', $_GET['day'])) {
            $day = $_GET['day'];
        } else {
            $day = Carbon::now()->format('Y-m-d');
        }

        // $questionCount = Auth::user()->questions()->where('next', '<=', $day)->count();

        $questionIds = Auth::user()->questions()->where('next', '<=', $day)->pluck('id')->toArray();

        session(compact('questionIds'));

        return $this->gotoNextQuestion();
    }

    public function gotoNextQuestion()
    {
        $questionIds = session('questionIds', []);

        if (empty($questionIds)) {
            return redirect()->route('review.done');
        }

        $id = array_shift($questionIds);
        $question = Question::find($id);

        session(compact('questionIds'));

        return redirect()->route('review.ask', compact('question'));
    }

    public function done()
    {
        return view('review.done');
    }

    public function ask(Question $question)
    {
        return view('review.ask', compact('question'));
    }

    public function answer(Question $question)
    {
        $options = [
            5 => 'perfect response',
            4 => 'correct response after a hesitation',
            3 => 'correct response recalled with serious difficulty',
            2 => 'incorrect response; where the correct one seemed easy to recall',
            1 => 'incorrect response; the correct one remembered',
            0 => 'complete blackout',
        ];

        return view('review.answer', compact('question', 'options'));
    }

    public function update(Request $request, Question $question)
    {
        $questionIds = session('questionIds', []);

        $q = max(0, min(5, intval($request->score)));

        if ($q < 3) {
            $question->n = 1;
            $question->i = 1;
        } else {
            $question->ef = $question->calculateEf($q);
        }

        if ($q < 4) {
            array_push($questionIds, $question->id);
        } else {
            $question->n++;
            $question->i = $question->calculateI($question->n);
            $question->next = $question->calculateNext($question->i);
        }

        $question->save();

        session(compact('questionIds'));

        return $this->gotoNextQuestion();
    }
}
