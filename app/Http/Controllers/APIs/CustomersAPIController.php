<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomersAPIController extends Controller
{
   public static function checkUDID(Request $request)
   {
       return self::checkCustomer($request);
   }

   public static function checkCustomer($request)
   {
       $accessKey = request()->header('ipaw_store_access_key');
       $customerUDID = $request->udid;
       $encryptedUDID = hash('sha256', $customerUDID);
       // Check AccessKey
       if($accessKey == $encryptedUDID)
       {
           // check udid from database
           $customer = Customer::where('udid', '=', $customerUDID);
           if($customer->count() != 0)
           {
               $groupName = $customer->first()->groups->name;
               return array(
                   'success' => true,
                   'full_name' => $customer->first()->full_name,
                   'group_name' => $groupName,
                   'message' => 'تم التحقق من المشترك',
               );

           }else{
               return array(
                   'success' => false,
                   'message' => 'رقم الجهاز غير معروف او ليس مسجل في قواعد البيانات'
               );
           }
       }else{
           return array(
               'success' => false,
               'message' => 'ليس لديك صلاحيات للوصول للمعلومات.'
           );
       }
   }
}
