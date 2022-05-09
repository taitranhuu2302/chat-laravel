<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
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
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }

    public function test_get_home_view_login()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard');
    }
}
