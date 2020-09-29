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

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function(){

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/users', 'UsersController');

    // MARK: - Groups Route
    Route::resource('/groups', 'GroupsController');
    Route::post('/groups/ajax/delete', 'GroupsController@deleteAjax')->name('groups.ajax.delete');

    // MARK: - Customers Route
    Route::resource('/customers', 'CustomersController');
    Route::post('/customers/ajax/compensationOfSpecificCustomers', 'CustomersController@compensationOfSpecificCustomers')->name('customers.ajax.compensationOfSpecificCustomers');
    Route::post('/customers/ajax/compensationOfAllCustomers', 'CustomersController@compensationOfAllCustomers')->name('customers.ajax.compensationOfAllCustomers');
    Route::post('/customers/ajax/delete', 'CustomersController@deleteAjax')->name('customers.ajax.delete');


    // MARK: - Applications Route
    Route::resource('/applications', 'ApplicationsInfoController');
    Route::post('/applications/ajax/uploadApp', 'ApplicationsInfoController@uploadApp')->name('applications.ajax.uploadApp');
    Route::post('/applications/ajax/getListApp', 'ApplicationsInfoController@getListApp')->name('applications.ajax.getListApp');
    Route::post('/applications/ajax/appSearch', 'ApplicationsInfoController@appSearch')->name('applications.ajax.appSearch');
    Route::post('/applications/ajax/resignApp', 'ApplicationsInfoController@resignAppAjax')->name('applications.ajax.resignApp');
    Route::post('/applications/ajax/sortable', 'ApplicationsInfoController@updateSorTable')->name('applications.ajax.sortable');
    Route::post('/applications/ajax/delete', 'ApplicationsInfoController@deleteAjax')->name('applications.ajax.delete');


    // MARK: - Applications Route
    Route::get('/orders', 'OrdersController@index')->name('orders.index');
    Route::post('/orders/ajax/active', 'OrdersController@active')->name('orders.ajax.active');
    Route::post('/orders/ajax/delete', 'OrdersController@deleteAjax')->name('orders.ajax.delete');

    // MARK: - NotificationSetting Route
    Route::get('/notification/setting', 'NotificationSettingController@index')->name('notification.index');
    Route::post('/notification/setting', 'NotificationSettingController@update')->name('notification.update');

    // MARK: - BankAccounts Route
    Route::resource('/bank/accounts', 'BankAccountsController');
    Route::post('/bank/accounts/ajax/delete', 'BankAccountsController@deleteAjax')->name('accounts.ajax.delete');

    // MARK: - settings Route
    Route::get('/settings', 'SettingsController@index')->name('settings.index');
    Route::post('/settings', 'SettingsController@update')->name('settings.update');

    // MARK: - Active Code Route
    Route::get('/active/code', 'ActiveCodeController@index')->name('active.code.index');
    Route::post('/active/code/create', 'ActiveCodeController@create')->name('active.code.create');
    Route::post('/active/code/ajax/delete', 'ActiveCodeController@deleteAjax')->name('active.code.ajax.delete');


});
