<?php

namespace App\Http\Controllers\APIs;

use App\Application;
use App\ApplicationsInfo;
use App\ConstantsHelper;
use App\Customer;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\ResignApp;
use App\Setting;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ApplicationsAPIController extends Controller
{
    public function lastAddedApps(Request $request)
    {
        $customer = CustomersAPIController::checkCustomer($request);

        if($customer['success'] == true)
        {
            $settingAppBundle = Setting::all()->first()->app_bundle;
            // MARK:- GET Last Added Apps
            $customerGroup = Customer::where('udid', '=', $request->udid)->first()->group_id;
            $appStoreID = ApplicationsInfo::where('app_bundle', '=', $settingAppBundle)->first();
            $appsByGroupID = Application::where('group_id', '=', $customerGroup)->where('app_info_id', '!=', $appStoreID)->orderBy('created_at', 'DESC')->take(10)->get();

            return response()->json([
                'success' => $customer['success'],
                'data' => ApplicationResource::collection($appsByGroupID),
            ]);

        }else{
            return $customer;
        }
    }
    public function randomApps(Request $request)
    {
        $customer = CustomersAPIController::checkCustomer($request);

        if($customer['success'] == true)
        {
            $settingAppBundle = Setting::all()->first()->app_bundle;
            // MARK:- GET Last Added Apps
            $customerGroup = Customer::where('udid', '=', $request->udid)->first()->group_id;
            $appStoreID = ApplicationsInfo::where('app_bundle', '=', $settingAppBundle)->first();
            $randomApps = Application::where('group_id', '=', $customerGroup)->where('app_info_id', '!=', $appStoreID)->orderBy(DB::raw('RAND()'))->take(10)->get();

            return response()->json([
                'success' => $customer['success'],
                'data' => ApplicationResource::collection($randomApps),
            ]);

        }else{
            return $customer;
        }
    }
    public function allApps(Request $request)
    {
        $customer = CustomersAPIController::checkCustomer($request);

        if($customer['success'] == true)
        {
            // MARK:- GET Last Added Apps
            $allApps = [];
            $settingAppBundle = Setting::all()->first()->app_bundle;
            // MARK:- GET Last Added Apps
            $customerGroup = Customer::where('udid', '=', $request->udid)->first()->group_id;
            $appsByGroup = Application::where('group_id', '=', $customerGroup)->get();
            $allAppsInfo = ApplicationsInfo::where('app_bundle', '!=', $settingAppBundle)->orderBy('app_arrangement', 'ASC')->get();

            foreach ($allAppsInfo as $appInfo){
                foreach ($appsByGroup as $apps)
                {
                    if($appInfo->id == $apps->app_info_id){
                        $allApps[] = $apps;
                    }
                }
            }

            return response()->json([
                'success' => $customer['success'],
                'data' => ApplicationResource::collection($allApps),
            ]);

        }else{
            return $customer;
        }
    }

    public function getPlist($id, $udid, $encudid, $ipaURL = "")
    {
        $accessKey = $encudid;
        $appID = $id;

        $encryptedUDID = hash('sha256', $udid);
        // Check AccessKey
        if($accessKey == $encryptedUDID) {
            $customerGroup = Customer::where('udid', '=', $udid);
            if ($customerGroup->count() != 0) {
                $groupFolder = $customerGroup->first()->groups->folder;
                if($ipaURL != ''){
                    $appIpa = URL::to('/') . '/storage/store/_groups/' . $groupFolder . '/' . $customerGroup->first()->id .'/'. $ipaURL;
                    $appIcon = URL::to('/') . '/storage/store/_groups/' . $groupFolder . '/' . $customerGroup->first()->id .'/'. $ipaURL.'.png';
                    $appBundle = 'com.abdullah.'.$this->randomBundle(8).'';
                    $appVersion = '1.0';
                    $appName = 'تطبيق خارجي';
                    return view('api.plist.manifest', compact('appIpa', 'appIcon', 'appBundle', 'appVersion', 'appName'));
                }else{
                    $appByGroup = Application::where('group_id', '=', $customerGroup->first()->group_id)->where('id', '=', $appID)->first();
                    $allAppsInfo = $appByGroup->applicationsInfo;
                    $appIpa = URL::to('/') . '/storage/store/_groups/' . $groupFolder . '/' . $appByGroup->app_ipa;
                    $appIcon = URL::to('/') . '/storage/store/_icon/' . $allAppsInfo->app_icon;
                    $appBundle = $allAppsInfo->app_bundle;
                    $appVersion = $allAppsInfo->app_version;
                    $appName = $allAppsInfo->app_name;
                    return view('api.plist.manifest', compact('appIpa', 'appIcon', 'appBundle', 'appVersion', 'appName'));
                }
            } else {
                return array(
                    'success' => false,
                    'message' => 'رقم الجهاز غير معروف او ليس مسجل في قواعد البيانات'
                );
            }
        }else{
            return response()->json([
                'message' =>  'حدث خطاء غير متوقع.',
                'success' => false
            ]);
        }

    }

    public function resignAppOutUrl(Request $request)
    {
        $customer = CustomersAPIController::checkCustomer($request);
        if($customer['success'] == true)
        {
            $customerGroup = Customer::where('udid', '=', $request->udid)->first();
            $getGroups = Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->where('id', '=', $customerGroup->group_id)->first();


            $dirDownloadIPA = $this->downloadFileIPA($request->url_ipa, $customerGroup->id);
            if(isset($dirDownloadIPA))
            {
                $groupFolder = 'public/store/_groups/'.$getGroups['folder'];
                $FolderResignCustomer = 'app/'.$groupFolder.'/'.$customerGroup->id.'/resign/';
                // resign app
                if(!File::exists(storage_path($FolderResignCustomer))){
                    $result = File::makeDirectory(storage_path($FolderResignCustomer), 0775, true);
                }

                $getPrivateGroupFolder = storage_path('app/private/store/_groups/'.$getGroups['folder']);
                $getFileP12 = $getPrivateGroupFolder.'/_files/'.$getGroups->appleFiles()->where('file_extension', '=', 'p12')->get()[0]['file_name'].'.p12';
                $getFileProfile = $getPrivateGroupFolder.'/_files/profile.mobileprovision';
                $randomName = Str::random(40);
                $ipaRandomName = $randomName.'.ipa';
                $newFileIPA =  storage_path($FolderResignCustomer.$ipaRandomName);
                $fileIPA = storage_path('app').'/'.$dirDownloadIPA;
                // MARK: - Get All Groups Active
                $cmdLine = ConstantsHelper::SIGN_DIRECTION." -k ". $getFileP12 . ' -m ' . $getFileProfile . ' -o ' . $newFileIPA . ' -z 9 ' . $fileIPA;
                $process = new Process($cmdLine);
                $process->run();

                // add to resign app
                $create = ResignApp::create([
                    'customer_id' => $customerGroup->id,
                    'app_ipa' => $ipaRandomName,
                ]);

                if(isset($create))
                {
                    File::delete($fileIPA);
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
        }else{
            return $customer;
        }
    }
    private  function downloadFileIPA($url, $customer_id)
    {
        $customer =  Customer::where('id', '=', $customer_id);
        if($customer->count() != 0)
        {
            $groupFolder = $customer->first()->groups->folder;
            $this->client = new Client(['base_uri' => $url]);
            $response = $this->client->request(
                "GET", "",
                [
                    'verify' => true,
                    'headers' => [
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36',
                    ],
                    'allow_redirects' => false
                ]
            );
            $fileName = sha1(date('YmdHis') . uniqid()).'.ipa';
            $dir ='public/store/_groups/'.$groupFolder.'/'.$customer->first()->id.'/download/'.$fileName;
            $download = Storage::put($dir, $response->getBody());
            if (isset($download))
            {
                return $dir;
            }
        }
    }

    public function resignApp(Request $request)
    {
        $customer = CustomersAPIController::checkCustomer($request);
        if($customer['success'] == true)
        {
            $customerGroup = Customer::where('udid', '=', $request->udid)->first();
            $getGroups = Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->where('id', '=', $customerGroup->group_id)->first();
            $getAppInfo = Application::where('id', '=', $request->app_id)->first();
            $getApplicationsInfo = $getAppInfo->applicationsInfo->first();

            // Folders
            $groupFolder = 'public/store/_groups/'.$getGroups['folder'];
            $FolderResignCustomer = 'app/'.$groupFolder.'/'.$customerGroup->id.'/resign/';
            if(!File::exists(storage_path($FolderResignCustomer))){
                File::makeDirectory(storage_path($FolderResignCustomer), 0775, true);
            }

            $urlIPA = [];
            for ($x = 1; $x <= $request->duplicate_num; $x++)
            {
                // App Info
                $appName = $request->app_name == '' ? $getApplicationsInfo->app_name.' '.$x : $request->app_name.' '.$x;
                $appBundle = $request->app_bundle == '' ? $getApplicationsInfo->app_bundle.''.$x : $request->app_bundle.''.$x;
                // resign app
                $getPrivateGroupFolder = storage_path('app/private/store/_groups/'.$getGroups['folder']);
                $getFileP12 = $getPrivateGroupFolder.'/_files/'.$getGroups->appleFiles()->where('file_extension', '=', 'p12')->get()[0]['file_name'].'.p12';
                $getFileProfile = $getPrivateGroupFolder.'/_files/profile.mobileprovision';
                $randomName = Str::random(40);
                $ipaRandomName = $randomName.'.ipa';
                $newFileIPA =  storage_path($FolderResignCustomer.$ipaRandomName);
                $fileIPA = storage_path('app/'.$groupFolder.'/'.$getAppInfo->app_ipa);

                // MARK: - Get All Groups Active
                $cmdLine = ConstantsHelper::SIGN_DIRECTION." -k ". $getFileP12 . ' -m ' . $getFileProfile . ' -o ' . $newFileIPA . " -b '".$appBundle."' -n '".$appName."'  -z 9 " . $fileIPA;
                $process = new Process($cmdLine);
                $process->run();

                // add to resign app
                $create = ResignApp::create([
                    'customer_id' => $customerGroup->id,
                    'app_info_id' => $getApplicationsInfo->id,
                    'app_name' => $appName,
                    'app_bundle' => $appBundle,
                    'app_ipa' => $ipaRandomName,
                ]);

                $urlIPA[] = $ipaRandomName;
            }

            if(isset($create))
            {
                return response()->json([
                    'message' =>  'تم تكرار التطبيق وتوقيعة',
                    'resign_bundle' =>  $request->app_bundle == '' ? $getApplicationsInfo->app_bundle : $request->app_bundle,
                    'resign_dub_num' =>  $request->duplicate_num,
                    'url_ipa' => $urlIPA,
                    'resign_app' => true
                ]);
            }else{
                return response()->json([
                    'message' =>  'لم يتم توقيع التطبيق',
                    'resign_app' => false
                ]);
            }

        }
    }

    function randomBundle($length=4){
        return substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,$length);
    }
}

