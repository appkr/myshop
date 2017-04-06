<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    'health',
    'HealthController@index'
);

Route::post(
// 로그아웃은 Customer 것을 공용으로 사용합니다.
// 로그아웃 메서드는 전체 세션을 전부 삭제하기 때문입니다.
// @see Illuminate\Foundation\Auth\AuthenticatesUsers::logout
    'logout',
    'Auth\LoginController@logout'
)->name('logout');

// 비밀번호 초기화도 공용으로 사용합니다.
// Member는 백오피스에서만 계정 생성/수정하는 것이 일반적이기 때문입니다.
Route::get(
    'password/reset',
    'Auth\ForgotPasswordController@showLinkRequestForm'
)->name('password.request');
Route::post(
    'password/email',
    'Auth\ForgotPasswordController@sendResetLinkEmail'
)->name('password.email');
Route::get(
    'password/reset/{token}',
    'Auth\ResetPasswordController@showResetForm'
)->name('password.reset');
Route::post(
    'password/reset',
    'Auth\ResetPasswordController@reset'
)->name('password.reset.submit');

Route::prefix('customers')->group(function () {
    Route::get(
        '/',
        'CustomerController@dashboard'
    )->name('customers.dashboard');
    Route::get(
        'login',
        'Auth\Customer\LoginController@showLoginForm'
    )->name('customers.login');
    Route::post(
        'login',
        'Auth\Customer\LoginController@login'
    )->name('customers.login.submit');
    Route::get(
        'register',
        'Auth\Customer\RegisterController@showRegistrationForm'
    )->name('customers.register');
    Route::post(
        'register',
        'Auth\Customer\RegisterController@register'
    )->name('customers.register.submit');
    Route::get(
        'social/{provider}',
        'Auth\Customer\SocialController@execute'
    )->name('customers.social.login');
});

Route::prefix('members')->group(function () {
    Route::get(
        '/',
        'MemberController@dashboard'
    )->name('members.dashboard');
    Route::get(
        'login',
        'Auth\Member\LoginController@showLoginForm'
    )->name('members.login');
    Route::post(
        'login',
        'Auth\Member\LoginController@login'
    )->name('members.login.submit');

    // Member 등록이나 비밀번호 초기화는 보통 관리자만 접근할 수 있는 백오피스에서 합니다.
  
    Route::resource(
        'products',
        'Member\ProductController',
        ['except' => ['index', 'show']]
    );
});

Route::get(
    'products',
    'ProductController@index'
)->name('products.index');
Route::get(
    'products/{product}',
    'ProductController@show'
)->name('products.show');
Route::post(
    'products/images',
    'ImageController@store'
)->name('products.images.store');
