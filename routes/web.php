<?php

use Illuminate\Support\Facades\Route;


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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);
Route::get(
    '/verify/{id?}',
    function ($id = null) {
        return view('verify', ['id' => $id]);
    }
);
Route::get('get_data', 'App\Http\Controllers\UserController@get_data');

Route::get('parse', 'App\Http\Controllers\WebScrapController@get_data');

Route::post('/verify/submit', 'App\Http\Controllers\UserController@verify')->name('verify-form');
