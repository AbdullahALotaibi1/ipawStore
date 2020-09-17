<?php

use \Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// MARK: - Customers Route
Route::post('customer/check/udid','APIs\CustomersAPIController@checkUDID');

// MARK: - Applications Route
Route::post('applications/last_added_apps','APIs\ApplicationsAPIController@lastAddedApps');
Route::post('applications/random_apps','APIs\ApplicationsAPIController@randomApps');
Route::post('applications/all_apps','APIs\ApplicationsAPIController@allApps');
Route::get('applications/get_plist','APIs\ApplicationsAPIController@getPlist');
Route::post('applications/resign_app/url','APIs\ApplicationsAPIController@resignAppOutUrl');
Route::post('applications/resign_app','APIs\ApplicationsAPIController@resignApp');


