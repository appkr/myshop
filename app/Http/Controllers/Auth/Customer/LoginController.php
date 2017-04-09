<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest:customers', [
            'except' => 'logout'
        ]);
    }

    public function showLoginForm()
    {
        return view('auth.customers.login');
    }

    protected function guard()
    {
        return Auth::guard('customers');
    }
}
