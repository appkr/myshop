<?php

namespace App\Http\Controllers\Auth\Member;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/members';

    public function __construct()
    {
        $this->middleware('guest:members', [
            'except' => 'logout'
        ]);
    }

    public function showLoginForm()
    {
        return view('auth.members.login');
    }

    protected function guard()
    {
        return Auth::guard('members');
    }
}
