<?php

namespace App\Http\Controllers\Dashboard;

use App\ConstantsHelper;
use App\Customer;
use App\Group;
use App\Helpers\EncryptHelper;
use App\Http\Controllers\Controller;
use App\Services\Apple\APCore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ewt = new APCore();
//        return $ewt->downloadProfile('9QARU83927','YVAC3XXWN7', ['myacinfo' => 'DAWTKNV2800c767db8c746116279ff79f7e8ca6ade47d2b991e5cfd0fde7d1ae61ce2829af8199d28e2d8a406d31f415d0036053f5d5142a82d1bbc3b29f7ed33fea9355b4df31afb13a2f68fd7bc8d8f75e6999cf2cc47e586ebd5df767a304c3ea71541beb8a4234e100ccb11862a5139120bb44bf7df46f12f5572ba0a56cbb22a247d8b2665f81ffc4967c687d4bc95e7ad6bfadd654fd9fb4026f60c7c7e66c45bc396eb915fee8f0d2fc783702e3024820b987a5fb6e4061fb3f666dd1b6f05ad6242434fd5b81e0f3ee68586152cb3850e779232313a366e530f419415b5b44115638621ae1846c448f30da9629e88c1b1dbb797a6ca5001d00e77e8ce8be121233366661653231636365656630333834373163623435313464353937626264346565323636366264MVRYV2']);
//        return $ewt->performLogin('azoozka43@gmail.com','Azvip@1239');
//        return $ewt->performSendSecurityCode('e8f7a47e6343865110826d54835eec1b','1', ['JSESSIONID'=> 'D92C6DE766BE5A3B493A27216F01BA4D; Path=/; Secure; HttpOnly']);
//        return $ewt->performValidateSecurityCode('97c1cd8f271e79f10086a726dd573b03','433606',['JSESSIONID'=> 'B670C1A170CE6EF54712A3394A12506E; Path=/; Secure; HttpOnly']);
//        return AppleAuthentication::preformReLogin('vg65066@21cn.com','Af112211');
//        return $ewt->getAccountInfo();

        $groups = Group::paginate(10);

        $countFull = 0;
        foreach (Group::all() as $group)
        {
            $countCu = $group->customers()->count();
            if($countCu >= 100){
                $countFull++;
            }
        }

        $statistics = array(
            'count_group' => Group::all()->count(),
            'active_group' => Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->count(),
            'disabled_group' => Group::where('status', '=', ConstantsHelper::DISABLED_GROUP)->count(),
            'expired_group' => Group::whereDate('expiration_date', '<', now())->count(),
            'full_group' => $countFull,
        );

        return view('dashboard.groups.index', compact('groups', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // PageID => New
        if($request->page_id == 'new'){

            // MARK: - Validation request data
            $validationData = Validator::make($request->all(), [
                'name' => 'required|unique:groups',
                'apple_email' => 'required|email',
                'apple_password' => 'required',
                'file_p12' => 'required|max:5098|mimetypes:application/octet-stream',
                'send_code' => 'required|between:1,2'
            ]);

            // MARK: - Check if there error in request data
            if ($validationData->fails()){
                return redirect()->back()->withErrors($validationData->errors())->withInput();
            }

            // MARK: - Login with apple developer account
            $APCore = new APCore();
            $response = $APCore->performLogin($request->apple_email, $request->apple_password, [], $request->send_code);

            // MARK: - Fail Login
            if($response['success'] == false){
                $appleMessage = $response['errorMessage'];
                return redirect()->back()->with('appleMessage', $appleMessage)->withInput();
            }


            // MARK: - success login + Add Group Data + Save Apple Account
            $createStatus = self::createNewGroup($request);

            // if fail create group return to groups.index
            if($createStatus[0]['create_status'] != true){
                return Redirect::route('dashboard.groups.index');
            }
            $request['group_id'] = $createStatus[0]['group_id'];
            // MARK: - select the verification method
            return self::selectVerificationMethod($request, $response);

        }
        /**
         * Send two-factor code to apple
         */
        else if($request->page_id == 'send_code'){
            if(isset($request->send_to_phone) && $request->send_to_phone == 1) {
                return self::getRegisterDevicesTwoFactor($request);
            }
            return self::validateSecurityCode($request);
        }
        else if($request->page_id == 'select_devices'){
            return self::sendSecurityCode($request);
        }

        return Redirect::route('dashboard.groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $getCustomers = $group->customers()->get();
        $getAppleAccount = $group->appleAccount()->get();
        $getAllGroup = Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->where('id', '!=', $group->id)->get();
        return view('dashboard.groups.edit', compact('group', 'getCustomers', 'getAppleAccount', 'getAllGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if($request->page_id == 'information')
        {
            // MARK: - Validation request data
            $validationData = Validator::make($request->all(), [
                'name' => 'required|unique:groups,name,' . $group->id,
                'file_p12' => 'nullable|max:5098|mimetypes:application/octet-stream',
            ]);

            // MARK: - validator fails
            if($validationData->fails())
            {
                return redirect()->back()->withErrors($validationData->errors())->withInput();
            }

            if($request->file('file_p12')){
                // MARK: - Delete File old p12
                $appleFile = $group->appleFiles()->first();
                if($appleFile->file_extension == 'p12'){
                    Storage::delete('private/store/_groups/'.$group->folder.'/_files/'.$appleFile->file_name.'.p12');
                    $appleFile->delete();

                    // MARK: - Add New File
                    $fileName = $request->file('file_p12')->hashName();
                    $fileExtension = $request->file('file_p12')->getClientOriginalExtension();
                    $uploadFile = $request->file('file_p12')->storeAs('private/store/_groups/'.$group->folder.'/_files', $fileName.'.'.$fileExtension);
                    if(isset($uploadFile)){
                        $appleFiles = $group->appleFiles()->create([
                            'file_name' => $fileName,
                            'file_extension' => $fileExtension
                        ]);
                    }
                }
            }

            $updateGroup = $group->update([
                'name' => $request->name,
                'status' => $request->status == 'on' ? ConstantsHelper::ACTIVE_GROUP : ConstantsHelper::DISABLED_GROUP,
            ]);

            if(isset($updateGroup)){
                Session::flash('message', 'تم تعديل  ('. $request->name.') بنحاج.');
                return Redirect::route('dashboard.groups.index');
            }

        }
        else if($request->page_id == 'appleAccount'){
            // MARK: - Validation request data
            $validationData = Validator::make($request->all(), [
                'apple_email' => 'required|email',
                'apple_password' => 'required',
            ]);

            // MARK: - Check if there error in request data
            if ($validationData->fails()){
                return redirect()->back()->withErrors($validationData->errors())->withInput();
            }

            // MARK:- Delete Last Cookies
            $deleteCookies = File::deleteDirectory(storage_path('app/private/apple/cookies/'.$request->apple_email));

            // MARK: - Login with apple developer account
            $APCore = new APCore();
            $response = $APCore->performLogin($request->apple_email, $request->apple_password, [], $request->send_code);

            // MARK: - Fail Login
            if($response['success'] == false){
                $appleMessage = $response['errorMessage'];
                return redirect()->back()->with('appleMessage', $appleMessage)->withInput();
            }

            $request['group_id'] = $group->id;
            // MARK: - select the verification method
            return self::selectVerificationMethod($request, $response);

        }
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {

    }

    public function deleteAjax(Request $request)
    {

        $group = Group::find($request->group_id);

        if($group->count() != 0){
            $getAppleEmail = $group->appleAccount()->first()->apple_email;

            // MARK: - Delete All Folders
            // MARK: - Delete Cookies file
            $deleteCookies = File::deleteDirectory(storage_path('app/private/apple/cookies/'.EncryptHelper::Decrypt($getAppleEmail)));
            // MARK: - Delete App + profile + p12 Files
            $deleteAPP = File::deleteDirectory(storage_path('app/private/store/_groups/'.$group->folder));
            // MARK: - Delete All database for group
            $deleteGroup = $group->delete();

            // MARK: - Delete Group
            return response()->json([
                'deleteCookies' => $deleteCookies,
                'deleteAPP' => $deleteAPP,
//                'deleteGroup' => $deleteGroup,
            ]);
        }


    }




    private function createNewGroup($request)
    {
        $folder_name = uniqid();
        // MARK: - Create New Folder
        if(Storage::exists('private/store/_groups/'.$folder_name)) {
            $folder_name = uniqid();
        }
        $mDir = Storage::makeDirectory('private/store/_groups/'.$folder_name);
        // MARK:- Successful create folder
        if(isset($mDir)){
            $createGroup = Group::create([
                'name' => $request->name,
                'folder' => $folder_name,
                'status' => ConstantsHelper::NEED_UPDATE_LOGIN_APPLE_DEVELOPER,
            ]);
        }
        else{
            return array(['create_status' => false]);
        }

        // MARK:- Successful create new group
        if(isset($createGroup)){
            $appleAccount = $createGroup->appleAccount()->create([
                'apple_email' => EncryptHelper::Encrypt($request->apple_email),
                'apple_password' => EncryptHelper::Encrypt($request->apple_password)
            ]);
        }

        // MARK:- Upload p12 file
        if($request->file('file_p12')){
            $fileName = $request->file('file_p12')->hashName();
            $fileExtension = $request->file('file_p12')->getClientOriginalExtension();
            $uploadFile = $request->file('file_p12')->storeAs('private/store/_groups/'.$folder_name.'/_files', $fileName.'.'.$fileExtension);
            if(isset($uploadFile)){
                $appleFiles = $createGroup->appleFiles()->create([
                    'file_name' => $fileName,
                    'file_extension' => $fileExtension
                ]);
            }
        }

        return array(['create_status' => true, 'group_id' => $createGroup->id]);
    }

    private function selectVerificationMethod($request, $response)
    {
        // MARK: - Check Found Scnt Code
        if($response['scnt'] == '' || $response['scnt'] == null && $response['cookies']['JSESSIONID'] == null){
            return Redirect::route('dashboard.groups.index');
        }
        $group_id = $request->group_id;
        // send code to desktop
        if($request->send_code == 1){
            $scnt = $response['scnt'];
            $JSESSIONID = $response['cookies']['JSESSIONID'];
            return view('dashboard.groups.create_code', compact('scnt', 'JSESSIONID', 'group_id'));
        }
        // send code to device
        else{
            $scnt = $response['scnt'];
            $JSESSIONID = $response['cookies']['JSESSIONID'];
            $devices = $response['devices'];
            return view('dashboard.groups.create_devices', compact('scnt', 'devices', 'group_id', 'JSESSIONID'));
        }
    }

    private function validateSecurityCode($request){
        // MARK: - Check Found Scnt Code
        if($request->scnt == '' || $request->scnt == null){
            return Redirect::route('dashboard.groups.index');
        }
        // MARK: - Get Group Info
        $getGroup = Group::find($request->group_id);

        // MARK: - Check there is Account
        if($getGroup->count() != 0){
            $APCore = new APCore();
            $JSESSIONID = $request->JSESSIONID;
            $response = $APCore->performValidateSecurityCode($request->scnt, $request->login_code, ['JSESSIONID'=> $JSESSIONID]);//AppleAuthentication::performValidateSecurityCode(,,EncryptHelper::Decrypt($appleEmail));

            // Check if there errors or not
            if($response['success'] == false){
                $errorMessage = $response['errorMessage'];
                $scnt = $response['scnt'];
                $group_id = $request->group_id;
                return view('dashboard.groups.create_code', compact('scnt','group_id', 'errorMessage', 'JSESSIONID'));
            }

            // MARK: - UpdateLoginRemember
            $UpdateLogin = $getGroup->appleAccount()->update([
                'login_remember_key' => EncryptHelper::Encrypt($response['loginRememberKey']),
                'login_remember_value' => EncryptHelper::Encrypt($response['loginRememberValue']),
                'myacinfo' => EncryptHelper::Encrypt($response['myacinfo']),
            ]);

            // get account info
            $resAccountInfo = $APCore->getAccountInfo(['myacinfo'=> $response['myacinfo']], $request->group_id);//AppleAuthentication::getAccountInfo(EncryptHelper::Decrypt($appleEmail));
            if($resAccountInfo['success'] == true){

                // Convert timestamp to date
                $datetimeFormat = 'Y-m-d H:i:s';
                $date = new \DateTime();
                $date->setTimestamp(substr($resAccountInfo['date_expires'], 0, 10));

                // update status group
                $updateGroup = $getGroup->update([
                    'team_id' => $resAccountInfo['team_id'],
                    'expiration_date' => $date->format($datetimeFormat),
                    'status' => ConstantsHelper::ACTIVE_GROUP,
                ]);

                $devices = $resAccountInfo['registered_devices'];
                $addDevices = self::addDevicesToGroup($request->group_id, $devices);
                if($addDevices == 'success_add'){
                    Session::flash('message', 'تم اضافة المجموعة بنحاج.');
                    return Redirect::route('dashboard.groups.index');
                }
            }

        }

        return Redirect::route('dashboard.groups.index');
    }

    private function getRegisterDevicesTwoFactor($request)
    {
        // MARK: - Check Found Scnt Code
        if($request->scnt == '' || $request->scnt == null){
            return Redirect::route('dashboard.groups.index');
        }
        // MARK: - Get Group Info
        $getGroup = Group::find($request->group_id);
        // MARK: - Check there is Account
        if($getGroup->count() != 0){
            $APCore = new APCore();
            $JSESSIONID = $request->JSESSIONID;
            $response = $APCore->performGetPhoneNumbers($request->scnt, ['JSESSIONID'=> $JSESSIONID]);//AppleAuthentication::performGetPhoneNumbers(, EncryptHelper::Decrypt($appleEmail));
            if(isset($response['devices']) && $response['devices'] != null){
                $devices = $response['devices'];
                $scnt = $response['scnt'];
                $group_id = $request->group_id;
                return view('dashboard.groups.create_devices', compact('scnt', 'devices','group_id', 'JSESSIONID'));
            }
            return Redirect::route('dashboard.groups.index');
        }
        return Redirect::route('dashboard.groups.index');
    }

    private function sendSecurityCode($request)
    {
        // MARK: - Check Found Scnt Code
        if($request->scnt == '' || $request->scnt == null){
            return Redirect::route('dashboard.groups.index');
        }
        // MARK: - Get Group Info
        $getGroup = Group::find($request->group_id);
        // MARK: - Check there is Account
        if($getGroup->count() != 0){
            $APCore = new APCore();
            $JSESSIONID = $request->JSESSIONID;
            $response = $APCore->performSendSecurityCode($request->scnt,$request->device_id, ['JSESSIONID' => $JSESSIONID]);//AppleAuthentication::performSendSecurityCode(,EncryptHelper::Decrypt($appleEmail));
            $scnt = $response['scnt'];
            $group_id = $request->group_id;
            return view('dashboard.groups.create_code', compact('scnt', 'group_id', 'JSESSIONID'));
        }
        return Redirect::route('dashboard.groups.index');
    }

    private function addDevicesToGroup($group_id, $devices)
    {
        // MARK: - Get Group Info
        $getGroup = Group::find($group_id);

        foreach($devices as $device) {
            $checkUdid = Customer::where('udid', '=', $device['udid'])->where('group_id', '=', $group_id)->count();
            if($checkUdid == 0)
            {
                $getGroup->customers()->create([
                    'udid' => $device['udid'],
                    'device_type' => $device['devicePlatform'],
                    'device_model' => $device['model'],
                    'device_added' => date("Y-m-d H:i:s",strtotime($device['added_date'])),
                    'status' => ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER
                ]);
            }
        }

        return "success_add";
    }
}
