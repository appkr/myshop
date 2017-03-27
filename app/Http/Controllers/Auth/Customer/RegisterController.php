<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Customer;
use App\Gender;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    const REGEX_PHONE_NUMBER = '/[0-9]{3,4}-[0-9]{3,4}-[0-9]{4}/';

    protected $redirectTo = '/customers';

    public function __construct()
    {
        $this->middleware('guest:customers');
    }

    public function showRegistrationForm()
    {
        return view('auth.customers.register');
    }

    protected function guard()
    {
        return Auth::guard('customers');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, $this->getValidationRules($data));
    }

    private function getValidationRules(array $data)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:customers',
            'password' => 'required|min:6|confirmed',
            'zipcode' => 'nullable|numeric',
            'address' => 'nullable|min:10',
            'phone_number' => 'nullable|regex:' . self::REGEX_PHONE_NUMBER,
            'date_of_birth' => 'nullable|date',
        ];

        if (isset($data['gender'])) {
            $rules['gender'] = 'in:' . implode(',', Gender::toArray());
        }

        return $rules;
    }

    protected function create(array $data)
    {
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'zipcode' => $data['zipcode'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => isset($data['gender']) ? Gender::getInstance($data['gender']) : null,
            'profile' => $data['profile'],
        ]);
    }
}