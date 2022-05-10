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
}
