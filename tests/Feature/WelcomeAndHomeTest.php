<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeAndHomeTest extends TestCase
{
    use RefreshDatabase;

    public function testWelcomeStatusOk()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Welcome to Learn!');
    }

    public function testHomeStatusOk()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSeeText('You are logged in!');
    }
}
