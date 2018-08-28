<?php

namespace Tests\Feature;

use App\Subject;
use App\Question;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
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

    public function testIndexStatusOk()
    {
        $response = $this->actingAs($this->user)
            ->get('/subjects/' . $this->subject->id . '/questions');

        $response->assertStatus(200);
        $response->assertSee('No questions');
    }

    public function testCreateStatusOk()
    {
        $response = $this->actingAs($this->user)
            ->get('/subjects/' . $this->subject->id . '/questions/create');

        $response->assertStatus(200);
        $response->assertSeeText('Create Question');
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)
            ->post('/subjects/' . $this->subject->id . '/questions', [
                'title' => 'New Question',
                'answer' => 'New Answer',
                'notes' => 'New Notes',
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'user_id' => $this->user->id,
            'subject_id' => $this->subject->id,
            'title' => 'New Question',
            'answer' => 'New Answer',
            'notes' => 'New Notes',
        ]);
    }

    public function testIndexWithQuestion()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)
            ->get('/subjects/' . $this->subject->id . '/questions');

        $response->assertStatus(200);
        $response->assertSeeText($question->title);
    }

    public function testShowStatusOk()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)
            ->get('/subjects/' . $this->subject->id . '/questions/' . $question->id);

        $response->assertStatus(200);
        $response->assertSeeText($question->title);
        $response->assertSeeText($question->answer);
        $response->assertSeeText($question->notes);
    }

    public function testEdit()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)
            ->get('/subjects/' . $this->subject->id . '/questions/' . $question->id . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Question');
        $response->assertSee($question->title);
        $response->assertSee($question->answer);
        $response->assertSee($question->notes);
    }

    public function testUpdate()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)
            ->put('/subjects/' . $this->subject->id . '/questions/' . $question->id, [
                'title' => 'Updated Question',
                'answer' => 'Updated Answer',
                'notes' => 'Updated Notes',
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'title' => 'Updated Question',
            'answer' => 'Updated Answer',
            'notes' => 'Updated Notes',
        ]);
    }

    public function testDelete()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)
            ->get('/subjects/' . $this->subject->id . '/questions/' . $question->id . '/delete');

        $response->assertStatus(200);
        $response->assertSeeText('Delete Question');
        $response->assertSeeText('Are you sure you want to permanently delete &quot;' . $question->title . '&quot;?');
    }

    public function testDestroy()
    {
        $question = $this->newQuestion();

        $response = $this->actingAs($this->user)
            ->delete('/subjects/' . $this->subject->id . '/questions/' . $question->id);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('questions', [
            'id' => $question->id,
        ]);
    }
}
