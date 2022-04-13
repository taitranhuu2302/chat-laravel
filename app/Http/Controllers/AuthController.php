<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function viewLogin(): View
    {
        return View('auth.login');
    }
}
