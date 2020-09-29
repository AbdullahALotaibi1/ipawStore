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

use App\BankAccounts;
use Illuminate\Support\Facades\Route;

Route::get("/info", function () {
    return phpinfo();
});

Route::get("/storage-link", function () {
    $targetFolder = storage_path("app/public");
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

Route::get('/', function () {

    $status = \App\Setting::all()->first()->status_store;
    if($status != 1){
        $message = "الموقع مغلق حالياً.";
        return view('welcome.error', compact('message'));
    }
    return view('welcome.home');
});

Route::get('/order/terms/{udid}/{deviceName}', function ($udid, $deviceName) {
    $status = \App\Setting::all()->first()->status_store;
    $statusOrders = \App\Setting::all()->first()->status_orders;
    if($statusOrders != 1){
        $message = "الطلبات مغلقه حالياً.";
        return view('welcome.error', compact('message'));
    }
    if($status != 1){
        $message = "الموقع مغلق حالياً.";
        return view('welcome.error', compact('message'));
    }

    // GET BANK INFO :-
    $banks = BankAccounts::all();
    return view('welcome.terms', compact('banks', 'deviceName', 'udid'));
});


Route::get('/order/new/{udid}/{deviceName}', function ($udid, $deviceName) {
    $status = \App\Setting::all()->first()->status_store;
    if($status != 1){
        $message = "الموقع مغلق حالياً.";
        return view('welcome.error', compact('message'));
    }
    $statusOrders = \App\Setting::all()->first()->status_orders;
    if($statusOrders != 1){
        $message = "الطلبات مغلقه حالياً.";
        return view('welcome.error', compact('message'));
    }
    // GET BANK INFO :-
    $banks = BankAccounts::all();
    $deviceName = getAppleDeviceName($deviceName);
    return view('welcome.order', compact('banks','deviceName', 'udid'));
})->name('order.get.udid');

Route::post('/order/request', 'Dashboard\OrdersController@orderRequest')->name('order.request');
Route::post('/order/active/customer', 'Dashboard\OrdersController@activeCustomer')->name('active.customer');

Route::get('store/download/{udid}', function ($udid) {
    $status = \App\Setting::all()->first()->status_store;
    if($status != 1){
        $message = "الموقع مغلق حالياً.";
        return view('welcome.error', compact('message'));
    }
    // GET BANK INFO :-
    $customer = \App\Customer::where('udid', '=', $udid);
    if($customer->count() != 0){

        if($customer->first()->status == \App\ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER){
            return view('welcome.update', compact('udid'));
        }elseif($customer->first()->status == \App\ConstantsHelper::NEW_ORDERS_CUSTOMER){
            return \Illuminate\Support\Facades\Redirect::to('/');
        }elseif($customer->first()->status == \App\ConstantsHelper::ACTIVE_CUSTOMER){
            $getBundle = \App\Setting::all()->first();
            $getAppStoreInfo = \App\ApplicationsInfo::where('app_bundle', '=', $getBundle->app_bundle)->first();
            if($getAppStoreInfo != null)
            {
                $getGroup = $customer->first()->groups()->first();
                $getAppStoreID = $getGroup->applications->id;

                // perpare url
                $encryptedUDID = hash('sha256', $udid);
                $urlInstall = 'itms-services://?action=download-manifest&url='.config('app.url').'/api/applications/get_plist/'.$getAppStoreID.'/'.$udid.'/'.$encryptedUDID;
                return \Illuminate\Support\Facades\Redirect::away($urlInstall);
            }

        }else{
            return \Illuminate\Support\Facades\Redirect::to('/');
        }
    }else{
        return \Illuminate\Support\Facades\Redirect::to('/');
    }

})->name('download.appstore');

Route::post('/customer/update', 'Dashboard\OrdersController@updateRequest')->name('update.request');


Route::get('store/check/{udid}', function ($udid) {
    $status = \App\Setting::all()->first()->status_store;
    if($status != 1){
        $message = "الموقع مغلق حالياً.";
        return view('welcome.error', compact('message'));
    }
    return \Illuminate\Support\Facades\Redirect::away("iPawStore://udid/".$udid."");
});


function getAppleDeviceName($modle)
{
    switch ($modle) {
        case "i386" :
            return "iPhone Sireturnv mulator";
        case "x86_64" :
            return "iPhone Sireturn mulator";
        case "iPhone1,1" :
            return "iPhone";
        case "iPhone1,2" :
            return "iPhone 3G";
        case "iPhone2,1" :
            return "iPhone 3GS";
        case "iPhone3,1" :
            return "iPhone 4";
        case "iPhone3,2" :
            return "iPhone 4 GSM Rev A";
        case "iPhone3,3" :
            return "iPhone 4 CDMA";
        case "iPhone4,1" :
            return "iPhone 4S";
        case "iPhone5,1" :
            return "iPhone 5 (GSM)";
        case "iPhone5,2" :
            return "iPhone 5 (GSM+CDMA)";
        case "iPhone5,3" :
            return "iPhone 5C (GSM)";
        case "iPhone5,4" :
            return "iPhone 5C (Global)";
        case "iPhone6,1" :
            return "iPhone 5S (GSM)";
        case "iPhone6,2" :
            return "iPhone 5S (Global)";
        case "iPhone7,1" :
            return "iPhone 6 Plus";
        case "iPhone7,2" :
            return "iPhone 6";
        case "iPhone8,1" :
            return "iPhone 6s";
        case "iPhone8,2" :
            return "iPhone 6s Plus";
        case "iPhone8,3" :
            return "iPhone SE (GSM+CDMA)";
        case "iPhone8,4" :
            return "iPhone SE (GSM)";
        case "iPhone9,1" :
            return "iPhone 7";
        case "iPhone9,2" :
            return "iPhone 7 Plus";
        case "iPhone9,3" :
            return "iPhone 7";
        case "iPhone9,4" :
            return "iPhone 7 Plus";
        case "iPhone10,1" :
            return "iPhone 8";
        case "iPhone10,2" :
            return "iPhone 8 Plus";
        case "iPhone10,3" :
            return "iPhone X";
        case "iPhone10,4" :
            return "iPhone 8";
        case "iPhone10,5" :
            return "iPhone 8 Plus";
        case "iPhone10,6" :
            return "iPhone X GSM";
        case "iPhone11,2":
            return "iPhone XS";
        case "iPhone11,4":
            return "iPhone XS Max";
        case "iPhone11,6":
            return "iPhone XS Max";
        case "iPhone11,8":
            return "iPhone XR";
        case"iPod1,1" :
            return "1st Gen iPod";
        case "iPod2,1" :
            return "2nd Gen iPod";
        case "iPod3,1" :
            return "3rd Gen iPod";
        case "iPod4,1" :
            return "4th Gen iPod";
        case "iPod5,1" :
            return "5th Gen iPod";
        case "iPod7,1" :
            return "6th Gen iPod";
        case"Pad1,1" :
            return "iPad";
        case "iPad1,2" :
            return "iPad 3G";
        case "iPad2,1" :
            return "2nd Gen iPad";
        case "iPad2,2" :
            return "2nd Gen iPad GSM";
        case "iPad2,3" :
            return "2nd Gen iPad CDMA";
        case "iPad2,4" :
            return "2nd Gen iPad New Revision";
        case "iPad3,1" :
            return "3rd Gen iPad";
        case "iPad3,2" :
            return "3rd Gen iPad CDMA";
        case "iPad3,3" :
            return "3rd Gen iPad GSM";
        case "iPad2,5" :
            return "iPad mini";
        case "iPad2,6" :
            return "iPad mini GSM+LTE";
        case "iPad2,7" :
            return "iPad mini CDMA+LTE";
        case "iPad3,4" :
            return "4th Gen iPad";
        case "iPad3,5" :
            return "4th Gen iPad GSM+LTE";
        case "iPad3,6" :
            return "4th Gen iPad CDMA+LTE";
        case "iPad4,1" :
            return "iPad Air (WiFi)";
        case "iPad4,2" :
            return "iPad Air (GSM+CDMA)";
        case "iPad4,3" :
            return "1st Gen iPad Air (China)";
        case "iPad4,4" :
            return "iPad mini Retina (WiFi)";
        case "iPad4,5" :
            return "iPad mini Retina (GSM+CDMA)";
        case "iPad4,6" :
            return "iPad mini Retina (China)";
        case "iPad4,7" :
            return "iPad mini 3 (WiFi)";
        case "iPad4,8" :
            return "iPad mini 3 (GSM+CDMA)";
        case "iPad4,9" :
            return "iPad Mini 3 (China)";
        case "iPad5,1" :
            return "iPad mini 4 (WiFi)";
        case "iPad5,2" :
            return "4th Gen iPad mini (WiFi+Cellular)";
        case "iPad5,3" :
            return "iPad Air 2 (WiFi)";
        case "iPad5,4" :
            return "iPad Air 2 (Cellular)";
        case "iPad6,3" :
            return "iPad Pro (9.7 inch, WiFi)";
        case "iPad6,4" :
            return "iPad Pro (9.7 inch, WiFi+LTE)";
        case "iPad6,7" :
            return "iPad Pro (12.9 inch, WiFi)";
        case "iPad6,8" :
            return "iPad Pro (12.9 inch, WiFi+LTE)";
        case "iPad6,11" :
            return "iPad (2017)";
        case "iPad6,12" :
            return "iPad (2017)";
        case "iPad7,1" :
            return "iPad Pro 2G";
        case "iPad7,2" :
            return "iPad Pro 2G";
        case "iPad7,3" :
            return "iPad Pro 10.5-inch";
        case "iPad7,4" :
            return "iPad Pro 10.5-inch";
        case "iPad7,5" :
            return "iPad 6th Gen (WiFi)";
        case "iPad7,6" :
            return "iPad 6th Gen (WiFi+Cellular)";
        case"Watch1,1" :
            return "Apple Watch 38mm case";
        case "Watch1,2" :
            return "Apple Watch 38mm case";
        case "Watch2,6" :
            return "Apple Watch Series 1 38mm case";
        case "Watch2,7" :
            return "Apple Watch Series 1 42mm case";
        case "Watch2,3" :
            return "Apple Watch Series 2 38mm case";
        case "Watch2,4" :
            return "Apple Watch Series 2 42mm case";
        case "Watch3,1" :
            return "Apple Watch Series 3 38mm case (GPS+Cellular)";
        case "Watch3,2" :
            return "Apple Watch Series 3 42mm case (GPS+Cellular)";
        case "Watch3,3" :
            return "Apple Watch Series 3 38mm case (GPS)";
        case "Watch3,4" :
            return "Apple Watch Series 3 42mm case (GPS)";
        case "Watch4,1" :
            return "Apple Watch Series 4 40mm case (GPS)";
        case "Watch4,2" :
            return "Apple Watch Series 4 44mm case (GPS)";
        case "Watch4,3" :
            return "Apple Watch Series 4 40mm case (GPS+Cellular)";
        case "Watch4,4" :
            return "Apple Watch Series 4 44mm case (GPS+Cellular)";
    }

    return 'غير معروف';
}



Auth::routes(['register' => false, 'reset' => false]);
