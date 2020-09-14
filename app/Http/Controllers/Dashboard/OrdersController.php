<?php

namespace App\Http\Controllers\Dashboard;

use App\ConstantsHelper;
use App\Customer;
use App\Group;
use App\Helpers\EncryptHelper;
use App\Http\Controllers\Controller;
use App\Services\Apple\APCore;
use App\Services\Apple\DevicesHelper;
use App\Services\Apple\ProfilesHelper;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Customer::where('status', '=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->paginate(15);
        $getGroups = Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->get();
        return view('dashboard.orders.index', compact('orders', 'getGroups'));
    }


    function active(Request $request)
    {
        $getCustomer =  Customer::where('status', '=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->where('id', '=', $request->customer_id); //->get();

        if($getCustomer->count() != 0)
        {
            $getGroup = Group::find($request->group_id);
            if($getGroup->count() != 0){

                // apple certificates info
                $team_id = $getGroup->team_id;

                // re-login apple developer
                $appleAccount = $getGroup->appleAccount()->first();
                $apple_email = EncryptHelper::Decrypt($appleAccount->apple_email);
                $apple_password = EncryptHelper::Decrypt($appleAccount->apple_password);
                $login_remember_key = EncryptHelper::Decrypt($appleAccount->login_remember_key);
                $login_remember_value = EncryptHelper::Decrypt($appleAccount->login_remember_value);

                $APCore = new APCore();
                $loginResponse = $APCore->performLogin($apple_email, $apple_password, [''.$login_remember_key.'' => ''.$login_remember_value.'']);
                if(isset($loginResponse['scnt']))
                {
                    return Response()->json([
                        'success' => false,
                        'message' => 'عليك تجديد تسجيل الدخول لحساب المطورين من خلال المجموعة'
                    ]);
                }
                $response = DevicesHelper::validateDevices(['myacinfo' => $loginResponse['myacinfo']], $team_id, $getCustomer->first()->udid, $getCustomer->first()->full_name);
                if(isset($response)){
                    if($response == 'success_download')
                    {

                        // Move The customer to anther group
                       $update = $getCustomer->update([
                            'group_id' => $request->group_id,
                            'status' => ConstantsHelper::ACTIVE_CUSTOMER
                        ]);

                       if(isset($update)){
                           return Response()->json([
                               'success' => true,
                               'message' => 'تم اضافة المشترك وتفعيلة في المجموعة'
                           ]);
                       }else{
                           return Response()->json([
                               'success' => true,
                               'message' => 'تم اضافة المشترك الى حساب المطورين وتفعيلة ولكن حدث خطاء اثناء تحويل المشترك الرجاء التواصل مع مبرمج السكربت لحل المشكلة. "هذا الخطاء نادر الحدث "'
                           ]);
                       }

                    }else{
                        return Response()->json([
                            'success' => false,
                            'message' => $response['message']
                        ]);
                    }
                }else{
                    return Response()->json([
                        'success' => false,
                        'message' => 'يوجد خطاء في اضافة المشترك'
                    ]);
                }
            }
        }
        return $getCustomer;
    }


    public function deleteAjax(Request $request)
    {
        $order = Customer::where('id', '=', $request->order_id)->where('status', '=', ConstantsHelper::NEW_ORDERS_CUSTOMER);

        if($order->count() != 0){
            $order->delete();
            return Response()->json([
                'success' => true,
                'message' => 'تم حذف الطلب بنجاح'
            ]);
        }

        return Response()->json([
            'success' => false,
            'message' => 'حدث خطاء غير متوقع'
        ]);
    }
}
