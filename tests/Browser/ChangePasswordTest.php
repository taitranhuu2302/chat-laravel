<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChangePasswordTest extends DuskTestCase
{

    public function test_get_view_change_password_when_not_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/auth/change-password')
                ->assertPathIs('/auth/login');
        });
    }

    public function test_all_field_is_required()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/auth/change-password')
                ->type('current_password', '')
                ->type('password', '')
                ->type('password_confirm', '')
                ->press('Đổi mật khẩu')
                ->assertSee('Mật khẩu cũ bắt buộc')
                ->assertSee('Mật khẩu mới bắt buộc')
                ->assertSee('Xác nhận mật khẩu bắt buộc');
        });
    }

    public function test_old_password_is_incorrect()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/auth/change-password')
                ->type('current_password', '123456')
                ->type('password', '123456')
                ->type('password_confirm', '123456')
                ->press('Đổi mật khẩu')
                ->assertSee('Mật khẩu cũ chưa chính xác.');
        });
    }

    public function test_new_password_must_be_more_than_6_character()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/auth/change-password')
                ->type('current_password', 'password')
                ->type('password', '123')
                ->type('password_confirm', '123')
                ->press('Đổi mật khẩu')
                ->assertSee('Mật khẩu mới phải có ít nhất 6 ký tự');
        });
    }

    public function test_confirm_password_is_incorrect()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/auth/change-password')
                ->type('current_password', 'password')
                ->type('password', '123123123')
                ->type('password_confirm', '123123')
                ->press('Đổi mật khẩu')
                ->assertSee('Mật khẩu xác nhận không khớp');
        });
    }


}
