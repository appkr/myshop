<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use Socialite;

class SocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customers');
    }

    public function execute(Request $request, string $provider)
    {
        if (! $request->has('code')) {
            return $this->redirectToProvider($provider);
        }

        return $this->handleProviderCallback($provider);
    }

    protected function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    protected function handleProviderCallback(string $provider)
    {
        /** @var AbstractUser $socialUser */
        $socialUser = Socialite::driver($provider)->user();
        $nativeUser = Customer::whereEmail($socialUser->getEmail())->first();

        if (! $nativeUser) {
            return redirect(route('customers.register', [
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
            ]));
        }

        auth('customers')->login($nativeUser);

        return redirect(route('customers.dashboard'));
    }
}
