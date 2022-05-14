<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    public function test_get_view_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->assertSee('Sign in to continue to Doot');
        });
    }

    public function test_email_and_password_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->press('Log In')
                ->assertSee('The email field is required.')
                ->assertSee('The password field is required.');
        });
    }

    public function test_password_must_be_more_than_6_character()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'test@gmail.com')
                ->type('password', 'test')
                ->press('Log In')
                ->assertSee('The password must be at least 6 characters.');
        });
    }

    public function test_email_is_not_the_correct_format()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'test')
                ->type('password', 'test1234')
                ->press('Log In')
                ->assertSee('Email is not in the correct format.');
        });
    }

    public function test_email_and_password_is_incorrect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'test@gmail.com')
                ->type('password', 'test123')
                ->press('Log In')
                ->assertSee('Email or password is incorrect.');
        });
    }

    public function test_login_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'password')
                ->press('Log In')
                ->assertRouteIs('dashboard')
                ->assertSee('Select a chat to read messages');
        });
    }
}
