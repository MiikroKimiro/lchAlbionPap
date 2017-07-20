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

Auth::routes();

Route::group(['middleware' => ['auth', 'isOfficer']], function () {
    Route::get('/', function () {
        return view('events.index');
    });
    Route::get('/events/new', 'EventController@create');
    Route::get('/events/index', 'EventController@index');
    Route::post('/events', 'EventController@store');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/events/{hashedId}', 'EventController@registerPap');
});

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/admin', function () {
        return view('admin');
    });
    Route::get('/admin/index', 'UserController@index');
    Route::patch('/admin/{id}/verify', 'UserController@verify');
    Route::patch('/admin/{id}/makeAdmin', 'UserController@isAdmin');
    Route::patch('/admin/{id}/makeOfficer', 'UserController@isOfficer');
});