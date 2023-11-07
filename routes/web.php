<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\SnsController@index');

Route::get('/subscribe', 'App\Http\Controllers\SnsController@subscribe');
Route::post('/subscribe', 'App\Http\Controllers\SnsController@confirm');
