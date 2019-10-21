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
Route::get('/smjena-postavke', 'HomeController@smjenaPostavke')->name('smjena.postavke');
Route::post('/smjena-postavke', 'HomeController@postSmjenaPostavke')->name('smjena.postavke');
Route::post('/smjene-api', 'HomeController@smjeneApi')->name('smjena.api');

Route::get('/zaboravljena-lozinka', 'ForgotPasswordController@showLinkRequestForm')->name('forgot');

Route::get('/kalendar/{md_id}', 'PublicController@index')->name('public.calendar');
Route::post('/kalendar-api/{md_id}', 'PublicController@smjeneApi')->name('public.calendar.api');

\Illuminate\Support\Facades\Auth::routes();


