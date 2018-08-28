<?php

namespace Tests\Feature;

use App\Subject;
use App\Question;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->subject = factory(Subject::class)->make();
        $this->subject->user()->associate($this->user);
        $this->subject->save();
    }

    protected function newQuestion(): Question
    {
        $question = factory(Question::class)->make();
        $question->user()->associate($this->user);
        $question->subject()->associate($this->subject);
        $question->save();

        return $question;
    }

    public function testIndexRedirect()
    {
        $response = $this->actingAs($this->user)->get('/review');

        $response->assertStatus(302);
    }

    public function testDoneStatusOk()
    {
        $response = $this->actingAs($this->user)->get('/review/done');

        $response->assertStatus(200);
        $response->assertSeeText('You\'ve completed all questions for today.');
    }

    public function testAskStatusOk()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->get('/review/' . $question->id);

        $response->assertStatus(200);
        $response->assertSeeText($this->subject->title);
        $response->assertSeeText($question->title);
        $response->assertDontSeeText($question->answer);
        $response->assertDontSeeText($question->notes);
    }

    public function testAnswerStatusOk()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->get('/review/' . $question->id . '/answer');

        $response->assertStatus(200);
        $response->assertSeeText($this->subject->title);
        $response->assertSeeText($question->title);
        $response->assertSeeText($question->answer);
        $response->assertSeeText($question->notes);
    }

    public function testAnswerScore5()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->post('/review/' . $question->id . '/answer', [
            'score' => '5',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'i' => 6,
            'n' => 2,
            'ef' => 2.5,
            'next' => date('Y-m-d', strtotime('+6 days')),
        ]);
    }

    public function testAnswerScore4()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->post('/review/' . $question->id . '/answer', [
            'score' => '4',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'i' => 6,
            'n' => 2,
            'ef' => 2.5,
            'next' => date('Y-m-d', strtotime('+6 days')),
        ]);
    }

    public function testAnswerScore3()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->post('/review/' . $question->id . '/answer', [
            'score' => '3',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'i' => 1,
            'n' => 1,
            'ef' => 2.36,
            'next' => date('Y-m-d'),
        ]);
    }

    public function testAnswerScore2()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->post('/review/' . $question->id . '/answer', [
            'score' => '2',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'i' => 1,
            'n' => 1,
            'ef' => 2.5,
            'next' => date('Y-m-d'),
        ]);
    }

    public function testAnswerScore1()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->post('/review/' . $question->id . '/answer', [
            'score' => '1',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'i' => 1,
            'n' => 1,
            'ef' => 2.5,
            'next' => date('Y-m-d'),
        ]);
    }

    public function testAnswerScore0()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)->post('/review/' . $question->id . '/answer', [
            'score' => '0',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'i' => 1,
            'n' => 1,
            'ef' => 2.5,
            'next' => date('Y-m-d'),
        ]);
    }
}
