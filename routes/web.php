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


Route::get('/', 'PatternsController@showFirst');
Route::post('pattern/save', 'PatternsController@savePattern');
Route::get('pattern', 'PatternsController@drawPattern');
Route::get('pattern/next', 'PatternsController@next');