<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->waitForText('Welcome Back !')
                ->assertSee('Welcome Back !');
        });
    }

    public function test_login_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'emlacuaanh1908@gmail.com')
                ->type('password', 'qweqwe')
                ->press('Log In')
                ->waitForText('Chats')
                ->assertSee('Chats');
        });
    }

    public function test_login_if_email_incorrect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/login')
                ->type('email', 'emlacuaanh@gmail.com')
                ->type('password', 'qweqwe')
                ->press('Log In')
                ->waitForText('Email or password is incorrect');
        });
    }
}
