<?php

namespace Tests\Feature;

use App\Subject;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    protected function newSubject(): Subject
    {
        $subject = factory(Subject::class)->make();
        $subject->user()->associate($this->user);
        $subject->save();

        return $subject;
    }

    public function testIndexStatusOk()
    {
        $response = $this->actingAs($this->user)->get('/subjects');

        $response->assertStatus(200);
        $response->assertSeeText('No subjects');
    }

    public function testCreateStatusOk()
    {
        $response = $this->actingAs($this->user)->get('/subjects');

        $response->assertStatus(200);
        $response->assertSeeText('No subjects');
    }

    public function testStore()
    {
        $response = $this->actingAs($this->user)->post('/subjects', [
            'title' => 'New Subject',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('subjects', [
            'title' => 'New Subject'
        ]);
    }

    public function testIndexWithSubject()
    {
        $subject = $this->newSubject();

        $response = $this->actingAs($this->user)->get('/subjects');

        $response->assertStatus(200);
        $response->assertSeeText($subject->title);
    }

    public function testShowRedirect()
    {
        $subject = $this->newSubject();

        $response = $this->actingAs($this->user)->get('/subjects/' . $subject->id);

        $response->assertStatus(302);
    }

    public function testEdit()
    {
        $subject = $this->newSubject();

        $response = $this->actingAs($this->user)->get('/subjects/' . $subject->id . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText('Edit Subject');
        $response->assertSee($subject->title);
    }

    public function testUpdate()
    {
        $subject = $this->newSubject();

        $response = $this->actingAs($this->user)->put('/subjects/' . $subject->id, [
            'title' => 'Updated Subject',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'title' => 'Updated Subject',
        ]);
    }

    public function testDelete()
    {
        $subject = $this->newSubject();

        $response = $this->actingAs($this->user)->get('/subjects/' . $subject->id . '/delete');

        $response->assertStatus(200);
        $response->assertSeeText('Delete Subject');
        $response->assertSeeText('Are you sure you want to permanently delete &quot;' . $subject->title . '&quot;?');
    }

    public function testDestroy()
    {
        $subject = $this->newSubject();

        $response = $this->actingAs($this->user)->delete('/subjects/' . $subject->id);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('subjects', [
            'id' => $subject->id,
        ]);
    }
}
