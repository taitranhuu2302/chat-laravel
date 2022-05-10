<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_get_home_view_not_login()
    {
        $this->withMiddleware();
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }

    public function test_get_home_view_login()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard');
    }
}
