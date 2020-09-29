<?php

namespace App\Http\Controllers\Dashboard;

use App\ActiveCode;
use App\Application;
use App\ApplicationsInfo;
use App\ConstantsHelper;
use App\Customer;
use App\Group;
use App\Helpers\EncryptHelper;
use App\Http\Controllers\Controller;
use App\ResignApp;
use App\Services\Apple\APCore;
use App\Services\Apple\DevicesHelper;
use App\Services\Apple\ProfilesHelper;
use App\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $fullName = "عبدالله العتيبي";
        $phoneNumber = "966555881837";
        $udid = "f603d8e14a6dfd5f98749aa8947221ed51849261";
        $deviceModel = "iPhone X MAX";
        $orderID = "1128";
        $codeStatus = true;
//        return $this->activeCustomer($orderID, $udid);
        return view('welcome.success_order', compact('fullName', 'phoneNumber', 'udid', 'deviceModel', 'orderID', 'codeStatus'));


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
                           $resign = $this->resignAppStore($request->group_id);
                           if(isset($resign)){
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

    function activeCustomer(Request $request)
    {
        $getCustomer =  Customer::where('status', '=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->where('id', '=', $request->order_id)->where('udid', '=', $request->udid); //->get();
        if($getCustomer->count() != 0)
        {
            // check register coupon
            $registerCoupon = $getCustomer->first()->register_coupon;
            if($registerCoupon != null || $registerCoupon != ''){
                // Active Code
                $checkActiveCode = ActiveCode::where('code', '=', $registerCoupon)->where('customer_id', '=', $getCustomer->first()->id)->count();
                if($checkActiveCode != 0){
                    // Active Account with Apple
                    // Check the empty groups
                    $groupsID = $this->emptyGroup();
                    if(count($groupsID) != 0)
                    {
                        $groupsMessage = [];
                        foreach ($groupsID as $groupID){
                            $addDevice = $this->appleAddDevice($groupID, $getCustomer->first()->id);
                            if($addDevice[0]['success'] == true) {
                                return response()->json([
                                    'message' =>  $addDevice[0]['message'],
                                    'success' => true
                                ]);
                            }
                            $groupsMessage[] = $addDevice[0]['message'];
                        }

                        return response()->json([
                            'message' =>  'جميع المجموعات ممتلئة، الرجاء التواصل مع صاحب المتجر.',
                            'success' => false
                        ]);
                    }else{
                        return response()->json([
                            'message' =>  'لاتوجد مجموعة متاحة حالياً الرجاء التواصل مع صاحب المتجر',
                            'success' => false
                        ]);
                    }

                }else{
                    return response()->json([
                        'message' =>  'عزيز المشترك الرجاء التواصل مع صاحب المتجر لحل المشكلة كود الاشتراك لعدم توافقه في قواعد البيانات.',
                        'success' => false
                    ]);
                }

            }else{
                return response()->json([
                    'message' =>  'عزيز المشترك ليس لديك كود اشتراك لذالك لن تتمكن من تفعيل حسابك.',
                    'success' => false
                ]);
            }

        }else{
            return response()->json([
                'message' =>  'المستخدم غير الموجود الرجاء التاكد من البيانات المدخلة.',
                'success' => false
            ]);
        }
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

    public function orderRequest(Request $request)
    {
        // MARK: - Validation request data
        $validationData = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone_number' => 'required|numeric|digits:12',
            'captcha' => 'required|captcha',
            'udid' => 'required|unique:customers',
        ],[
            'captcha.captcha' => 'الرجاء كتابة كود التحقق بشكل الصحيح'
        ]);

        // MARK: - Check if there error in request data
        if ($validationData->fails()){
            return redirect()->back()->withErrors($validationData->errors())->withInput();
        }

        $codeStatus = false;
        // MARK: - Check Register Coupon
        if($request->register_coupon != '' || $request->register_coupon != null)
        {
            $checkCode = ActiveCode::where('code', '=', $request->register_coupon);
            if($checkCode->count() == 0)
            {
                return redirect()->back()->with('register_coupon', 'الكود المستخدم غير صحيح')->withInput();
            }else if($checkCode->first()->customer_id != '' || $checkCode->first()->customer_id != null)
            {
                return redirect()->back()->with('register_coupon', 'كود الاشتراك مستخدم من قبل')->withInput();
            }else{
                $codeStatus = true;
            }
        }

        $type = stripos($request->device_model, "iPhone") !== false ? "iPhone" : '';
        if($type == '') { $type = stripos($request->device_model, "iPad") !== false ? "iPad" : ''; }
        // Create New Order
        $create = Customer::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'device_model' => $request->device_model,
            'udid' => $request->udid,
            'device_type' => $type,
            'register_coupon' => $request->register_coupon != '' ? $request->register_coupon : '',
            'status' => ConstantsHelper::NEW_ORDERS_CUSTOMER,
        ]);

        if($codeStatus == true)
        {
            $updateActiveCode = ActiveCode::where('code', '=', $request->register_coupon)->update([
                'customer_id' => $create->id
            ]);
        }

        if(isset($create))
        {
            $fullName = $request->full_name;
            $phoneNumber = $request->phone_number;
            $udid = $request->udid;
            $deviceModel = $request->device_model;
            $orderID = $create->id;
            return view('welcome.success_order', compact('fullName', 'phoneNumber', 'udid', 'deviceModel', 'orderID', 'codeStatus'));
        }
    }

    public function updateRequest(Request $request)
    {
        // MARK: - Validation request data
        $validationData = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone_number' => 'required|numeric|digits:12',
            'captcha' => 'required|captcha',
            'udid' => 'required',
        ],[
            'captcha.captcha' => 'الرجاء كتابة كود التحقق بشكل الصحيح'
        ]);

        // MARK: - Check if there error in request data
        if ($validationData->fails()){
            return redirect()->back()->withErrors($validationData->errors())->withInput();
        }

        $type = stripos($request->device_model, "iPhone") !== false ? "iPhone" : '';
        if($type == '') { $type = stripos($request->device_model, "iPad") !== false ? "iPad" : ''; }
        // Create New Order
        $update = Customer::where('udid', '=', $request->udid)->where('status', '=', ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER)->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'status' => ConstantsHelper::ACTIVE_CUSTOMER,
        ]);
        if(isset($update))
        {
            return Redirect::to('/store/download/'.$request->udid.'');
        }else{
            abort(404);
        }
    }

    public function resignAppStore($groupID)
    {
        $settingAppBundle = Setting::all()->first()->app_bundle;
        $appStoreID = ApplicationsInfo::where('app_bundle', '=', $settingAppBundle)->first();

        $getGroups = Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->where('id', '=', $groupID)->first();


        $getPrivateGroupFolder = storage_path('app/private/store/_groups/'.$getGroups['folder']);
        $getFileP12 = $getPrivateGroupFolder.'/_files/'.$getGroups->appleFiles()->where('file_extension', '=', 'p12')->get()[0]['file_name'].'.p12';
        $getFileProfile = $getPrivateGroupFolder.'/_files/profile.mobileprovision';
        $randomName = Str::random(40);
        $ipaRandomName = $randomName.'.ipa';

        $groupFolder = 'public/store/_groups/'.$getGroups['folder'];
        $FolderResignCustomer = 'app/'.$groupFolder.'/';

        $FolderResignDefault = 'app/private/store/_applications_default';


        $newFileIPA =  storage_path($FolderResignCustomer.$ipaRandomName);
        $fileIPA = storage_path($FolderResignDefault.'/'.$appStoreID->app_folder.'/'.$appStoreID->app_ipa);
        // MARK: - Get All Groups Active
        $cmdLine = ConstantsHelper::SIGN_DIRECTION." -k ". $getFileP12 . ' -m ' . $getFileProfile . ' -o ' . $newFileIPA . ' -z 9 ' . $fileIPA;
        $process = new Process($cmdLine);
        $process->run();

        // add to resign app
//        delete last ipa Store

        $oldIpaFile = Application::where('group_id', '=', $groupID)->where('app_info_id', '=', $appStoreID->id);
        $fileOldIPAName = $oldIpaFile->first()->app_ipa;
        $delete = $oldIpaFile->delete();
        $create = $appStoreID->applications()->create([
            'group_id' => $groupID,
            'app_plist' => 'sa',
            'app_ipa' => $ipaRandomName
        ]);

        if(isset($create))
        {
            File::delete(storage_path($FolderResignCustomer.$fileOldIPAName));
            return response()->json([
                'message' =>  'تم توقيع التطبيق',
                'resign_ipa' =>  $ipaRandomName,
                'resign_app' => true
            ]);

        }else{
            return response()->json([
                'message' =>  'لم يتم توقيع التطبيق',
                'resign_app' => false
            ]);
        }
    }

    private function emptyGroup()
    {
        $groupsID = [];
        foreach (Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->get() as $group)
        {
            $countCu = $group->customers()->count();
            if($countCu <= 108) {
                $groupsID[] = $group->id;
            }
        }
        return $groupsID;
    }

    private function appleAddDevice($groupID, $customerID)
    {
        $getCustomer =  Customer::where('id', '=', $customerID); //->get();
        $getGroup = Group::find($groupID);
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
                return array([
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
                        'group_id' => $groupID,
                        'status' => ConstantsHelper::ACTIVE_CUSTOMER
                    ]);

                    if(isset($update)){
                        $resign = $this->resignAppStore($groupID);
                        if(isset($resign)){
                            return array([
                                'success' => true,
                                'message' => 'تم اضافة المشترك وتفعيلة في المجموعة',
                            ]);

                        }else{
                            return array([
                                'success' => true,
                                'message' => '11تم اضافة المشترك الى حساب المطورين وتفعيلة ولكن حدث خطاء اثناء تحويل المشترك الرجاء التواصل مع مبرمج السكربت لحل المشكلة. "هذا الخطاء نادر الحدث "'
                            ]);

                        }
                    }else{
                        return array([
                            'success' => true,
                            'message' => 'تم اضافة المشترك الى حساب المطورين وتفعيلة ولكن حدث خطاء اثناء تحويل المشترك الرجاء التواصل مع مبرمج السكربت لحل المشكلة. "هذا الخطاء نادر الحدث "'
                        ]);

                    }

                }else{
                    return array([
                        'success' => false,
                        'message' => $response['message']
                    ]);

                }
            }else{
                return array([
                    'success' => false,
                    'message' => 'يوجد خطاء في اضافة المشترك'
                ]);

            }
        }else{
            return array([
                'success' => false,
                'message' => 'المجموعة غير متاحة'
            ]);
        }
    }
}
