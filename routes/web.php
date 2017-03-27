<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('health', 'HealthController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
