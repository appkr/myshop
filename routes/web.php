<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('health', 'HealthController@index');
