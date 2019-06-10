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

Route::get('/', 'WeatherController@index')->name('weather.index');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/weather', 'WeatherController@index')->name('weather.index');
Route::get('/weather/forecast/{city}', 'WeatherController@forecast')->name('weather.forecast');