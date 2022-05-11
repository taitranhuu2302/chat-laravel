<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

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
        $response->assertStatus(302);
    }

    public function test_change_password()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/auth/change-password', [
            'current_password' => $user->password,
            'password' => 'qweqweqwe',
            'password_confirm' => 'qweqweqwe',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
