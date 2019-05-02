<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('/enter', 'HomeController@enter')->name('enter');

Route::get('/login', 'LogController@login')->name('login');
Route::get('/register', 'LogController@register')->name('register');
Route::get('/logout', 'LogController@logout')->name('logout');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::post('/edit-user-required-data', 'DashboardController@editUserRequiredData')->name('edit-user-req');
Route::post('/edit-user-optional-data', 'DashboardController@editUserOptionalData')->name('edit-user-opt');

Route::post('/log-user', 'LogController@logUser')->name('log-user');
Route::post('/register-user', 'LogController@registerUser')->name('register-user');
Route::post('/verify-sms', 'LogController@verifySMS')->name('verify-sms');
