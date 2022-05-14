<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{

    public function test_get_view_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/register')
                ->assertSee('Sign up to continue to Doot');
        });
    }

    public function test_email_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/register')
                ->type('email', '')
                ->type('full_name', '')
                ->press('Sign Up')
                ->assertSee('The email field is required.')
                ->assertSee('The full name field is required.');
        });
    }

    public function test_email_is_not_the_correct_format()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/register')
                ->type('email', 'test')
                ->type('full_name', 'Tran Huu Tai')
                ->press('Sign Up')
                ->assertSee('Email is not in the correct format.');
        });
    }

    public function test_full_name_format_is_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/register')
                ->type('email', 'test1@gmail.com')
                ->type('full_name', 'Admin 123')
                ->press('Sign Up')
                ->assertSee('The full name format is invalid.');
        });
    }

    public function test_email_already_exists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/register')
                ->type('email', 'admin@gmail.com')
                ->type('full_name', 'Admin')
                ->press('Sign Up')
                ->assertSee('Email account already exists.');
        });
    }

    public function test_register_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/register')
                ->type('email', 'test123123@gmail.com')
                ->type('full_name', 'Tran Huu Tai')
                ->press('Sign Up')
                ->assertPathIs('/auth/login')
                ->assertSee('Please check your email to get your password.');
        });
    }


}
