<?php

use \Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('dashboard')->name('dashboard.')->group(function(){

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/users', 'UsersController');

    // MARK: - Groups Route
    Route::resource('/groups', 'GroupsController');
    Route::post('/groups/ajax/delete', 'GroupsController@deleteAjax')->name('groups.ajax.delete');



});
