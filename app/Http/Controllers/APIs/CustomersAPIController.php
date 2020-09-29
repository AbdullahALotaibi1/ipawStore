<?php

namespace App\Http\Controllers\APIs;

use App\ConstantsHelper;
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
//       $accessKey = request()->header('ipaw_store_access_key');
       $customerUDID = $request->udid;
       $accessKey = $request->ipaw_store_access_key;
       $encryptedUDID = hash('sha256', $customerUDID);


       // Check AccessKey
       if($accessKey == $encryptedUDID)
       {
           // check udid from database
           $customer = Customer::where('udid', '=', $customerUDID);
           if($customer->count() != 0)
           {
               if ($customer->first()->status == ConstantsHelper::ACTIVE_CUSTOMER){
                   $groupName = $customer->first()->groups->name;
                   return array(
                       'success' => true,
                       'full_name' => $customer->first()->full_name,
                       'group_name' => $groupName,
                       'message' => 'تم التحقق من المشترك',
                   );
               }elseif($customer->first()->status == ConstantsHelper::DISABLED_CUSTOMER){
                   return array(
                       'success' => false,
                       'message' => 'عزيز المشترك حسابك معلق الرجاء التواصل مع صاحب السكربت'
                   );
               }elseif($customer->first()->status == ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER){
                   return array(
                       'success' => false,
                       'message' => 'عزيز المشترك حسابك بحاجة لتحديث البيانات الرجاء التواصل مع صاحب السكربت'
                   );
               } else {
                   return array(
                       'success' => false,
                       'message' => 'الرجاء التواصل مع صاحب السكربت'
                   );
               }

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
