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
Route::get('applications/get_plist/{id}/{udid}/{encudid}/{ipaURL?}','APIs\ApplicationsAPIController@getPlist');
Route::post('applications/resign_app/url','APIs\ApplicationsAPIController@resignAppOutUrl');
Route::post('applications/resign_app','APIs\ApplicationsAPIController@resignApp');


// Login Route
Route::post('store/check/login/', function (\Illuminate\Support\Facades\Request $request) {
    // GET BANK INFO :-
    return $request->all();
    $customer = \App\Customer::where('udid', '=', $udid)->first();

    if($customer->count() != 0)
    {
        if($customer->status = \App\ConstantsHelper::ACTIVE_CUSTOMER)
        {
            return response()->json([
                'login_success' => true
            ]);
        }else if($customer->status = \App\ConstantsHelper::DISABLED_CUSTOMER){
            return response()->json([
                'login_success' => false,
                'message' => 'حسابك موقوف حالياً'
            ]);
        }else if($customer->status = \App\ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER){
            return response()->json([
                'login_success' => false,
                'message' => 'حسابك بحاجة لتحديث بيناته من خلال الموقع او تواصل مع صاحب السكربت.ً'
            ]);
        }else if($customer->status = \App\ConstantsHelper::NEW_ORDERS_CUSTOMER){
            return response()->json([
                'login_success' => false,
                'message' => 'لم يتم تفعيل حسابك الى الان.ً'
            ]);
        }else{
            return response()->json([
                'login_success' => false,
                'message' => 'الرجاء التواصل مع صاحب السكربت لحل المشكلة.'
            ]);
        }

    }else{
        return response()->json([
            'login_success' => false,
            'message' => 'الرجاء التواصل مع صاحب السكربت لحل المشكلة.'
        ]);
    }
});


Route::post('store/settings', function (){

    $setitngs = \App\Setting::all()->first();
    return response()->json([
        'success' => true,
        'twitter_account' => $setitngs->twitter_account,
        'snapchat_account' => $setitngs->snapchat_account,
        'telegram_account' => $setitngs->telegram_account,
        'whatsapp_account' => $setitngs->whatsapp_account
    ]);

});
