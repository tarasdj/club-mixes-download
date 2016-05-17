<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',
    [
        'uses' =>'MainController@HomePage'
    ]);

Route::get('/genre/{genre}',
    [
        'uses' =>'MainController@SingleGenre'
    ]);

Route::get('/artist/{artist}',
    [
        'uses' =>'MainController@SingleArtist'
    ]);

Route::get('/mix/{mix_url}',
    [
        'uses' =>'MainController@SingleMixView'
    ]);

Route::get('/test',
    [
        'uses' =>'MainController@Test'
    ]);
