<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function test_get_view_login()
    {
        $response = $this->get('/auth/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_get_view_register()
    {
        $response = $this->get('/auth/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_get_view_when_user_logged_in()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/auth/login');

        $response->assertRedirect('/');
    }

}
