<?php

namespace App\Http\Controllers\Dashboard;

use App\ApplicationsInfo;
use App\ConstantsHelper;
use App\Group;
use App\Helpers\EncryptHelper;
use App\Http\Controllers\Controller;
use App\Services\Ipa\IpaHelper;
use App\Services\iPhoneCake\iPhoneCake;
use App\Services\iPhoneCake\RequestHelper;
use Illuminate\Http\Request;
use CFPropertyList\CFPropertyList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ApplicationsInfoController extends Controller
{

    public function index()
    {
        $applications = ApplicationsInfo::orderBy('app_arrangement', 'ASC')->get();
        return view('dashboard.applications.index', compact('applications'));
    }

    public function edit($id)
    {
        $app = ApplicationsInfo::find($id);
        if($app->count() != 0){
            return view('dashboard.applications.edit', compact('app'));
        }
    }

    public function update(Request $request, $id)
    {

        $app = ApplicationsInfo::find($id);
        if($app->count() != 0){

            // MARK: - Validation request data
            $validationData = Validator::make($request->all(), [
                'app_name' => 'required',
                'app_version' => 'required',
                'app_bundle' => 'required',
            ]);

            // MARK: - validator fails
            if($validationData->fails())
            {
                return redirect()->back()->withErrors($validationData->errors())->withInput();
            }


            // Update
            $update = $app->update([
                'app_name' => $request->app_name,
                'app_version' => $request->app_version,
                'app_bundle' => $request->app_bundle,
            ]);

            if(isset($update)){
                Session::flash('message', 'تم تعديل  ('. $request->app_name.') بنحاج.');
                return Redirect::route('dashboard.applications.index');
            }
        }

        return Redirect::route('dashboard.applications.index');

    }

    public function uploadApp(Request $request)
    {

        if($request->hasFile('file')){

            $ipaPath = storage_path('app/private/store/_applications_default');
            $filesIPA = $request->file('file');

            if (!is_array($filesIPA)) {
                $filesIPA = [$filesIPA];
            }

            for ($i = 0; $i < count($filesIPA); $i++) {

                // Save File
                $file = $filesIPA[$i];
                $fileName = sha1(date('YmdHis') . uniqid());
                $saveFullName = $fileName . '.' . $file->getClientOriginalExtension();
                $upload = $file->move($ipaPath.'/'.$fileName, $saveFullName);

                // Get App Info
                if(isset($upload)){
                   return self::extractPlist($ipaPath, $fileName);
                }
            }
        }

        return "End Function";
    }

    private function extractPlist($ipaPath, $fileName)
    {
        $exPlist = IpaHelper::ExtractPlist($ipaPath.'/'.$fileName, $fileName.'.ipa');
        if ($exPlist['success'] == true){
            $parser = new CFPropertyList($exPlist['pathPlist']);
            $plist = $parser->toArray();
            // check info app
            return self::checkInfoApp($plist, $ipaPath.'/'.$fileName, $fileName);
        }
    }

    private function checkInfoApp($plist, $path, $ipaName)
    {
        $returnValue = [
            'success' => false,
        ];

        // check that the application exists in the databases
        $checkApp = ApplicationsInfo::where('app_name', '=', $plist['CFBundleName'])
            ->where('app_bundle', '=', $plist['CFBundleIdentifier']);

        // Found App
        if($checkApp->where('app_version', '=', $plist['CFBundleShortVersionString'])->count() != 0){
            // MARK: - Delete App + profile + p12 Files
            $deleteFolder = File::deleteDirectory($path);
            $returnValue['message'] = "({$plist['CFBundleName']}) التطبيق موجود مسبقاً";
            return $returnValue;
        }


        // Check if is this update
        $checkUpdateApp = $checkApp->where('app_version', '!=', $plist['CFBundleShortVersionString'])->count();
        if($checkUpdateApp != 0){
            // resign app and save new ipa
            $returnValue['message'] = "تم تحديث التطبيق ({$plist['CFBundleName']})
            الى الاصدار ({$plist['CFBundleShortVersionString']})";
            return $returnValue;
        }

        // create new app
        $createApp = ApplicationsInfo::create([
            'app_name' => $plist['CFBundleName'],
            'app_version' => $plist['CFBundleShortVersionString'],
            'app_bundle' => $plist['CFBundleIdentifier'],
            'app_icon' => $ipaName.'.ipa.png',
            'app_arrangement' => '0',
            'app_size' => self::formatSizeUnits(File::size($path.'/'.$ipaName.'.ipa')),
            'app_ipa' => $ipaName.'.ipa',
            'app_folder' => $ipaName,
        ]);

        if(isset($createApp))
        {
            // resign app
            return self::resignApp($createApp->id);
        }
        return $returnValue;
    }

    private function resignApp($appID)
    {
        $returnValue = [
            'success' => false
        ];

        $getApp = ApplicationsInfo::find($appID);

        // Check found App
        if($getApp->count() == 0){
            return $returnValue;
        }
        // MARK: - Get All Groups Active
        $getGroups = Group::where('status', '=', ConstantsHelper::ACTIVE_GROUP)->get();
        $numResignGroup = 0;
        foreach($getGroups as $group){
            $randomName = Str::random(40);
            $ipaRandomName = $randomName.'.ipa';
            $groupFolder = 'public/store/_groups/'.$group['folder'];
            $getPrivateGroupFolder = storage_path('app/private/store/_groups/'.$group['folder']);
            $getFileP12 = $getPrivateGroupFolder.'/_files/'.$group->appleFiles()->where('file_extension', '=', 'p12')->get()[0]['file_name'].'.p12';
            $getFileProfile = $getPrivateGroupFolder.'/_files/profile.mobileprovision';
            $newFileIPA = storage_path('app/'.$groupFolder.'/'.$ipaRandomName);
            $fileIPA = storage_path('app/private/store/_applications_default').'/'.$getApp->app_folder.'/'.$getApp->app_ipa;
            // Check exists folder
            if(!Storage::exists($groupFolder)) {
                Storage::makeDirectory($groupFolder);
            }

            // resign app
            $cmdLine = ConstantsHelper::SIGN_DIRECTION." -k ". $getFileP12 . ' -m ' . $getFileProfile . ' -o ' . $newFileIPA . ' -z 9 ' . $fileIPA;
            $returnValue['cmd'] = $cmdLine;
            $process = new Process($cmdLine);
            $process->run();
            $process->setTimeout(null);
            $process->setIdleTimeout(null);
            $outPut = $process->getOutput();

            if(isset($outPut)){
                $getApp->applications()->create([
                    'group_id' => $group->id,
                    'app_plist' => 'sa',
                    'app_ipa' => $ipaRandomName
                ]);
                $returnValue['success'] = true;
                $returnValue['message'] = 'تم توقيع تطبيق ('.$getApp->app_name.') على كل مجموعات المتاحة';
                $returnValue['cmd'] = $cmdLine;
            }
        }
        return $returnValue;
    }

    public function getListApp(Request $request)
    {
        $page = $request->page_id;
        $device = 1;
          return iPhoneCake::getListApp($page, $device);
    }

    public function appSearch(Request $request)
    {
        $page = $request->page_id;
        $device = 1;
        $query = $request->qsearch;
        return iPhoneCake::appSearch($page, $device, $query);
    }

    public function getIpaApp($appID)
    {
         return iPhoneCake::getIpaApp($appID);
    }

    public function resignAppAjax(Request $request)
    {
        if (isset($request)){
            $ipaLink = self::getIpaApp($request->app_id);
            // Download File
            $ipaRandomName = Str::random(40);
            $dir ='private/store/_applications_default/'.$ipaRandomName.'/'.$ipaRandomName.'.ipa';
            $down = RequestHelper::request($ipaLink['data']->link, $dir);

            if(isset($down))
            {
                $path = storage_path('app/private/store/_applications_default');
                return self::extractPlist($path, $ipaRandomName);
            }

            return $ipaLink;
        }
        return "fail";
    }

    public function updateSorTable(Request $request)
    {
        // MARK: - Variables
        $order = $request->order;
        foreach ($order as $row){
            $app_id = $row['id'];
            $app_arrangement = $row['position'];
            $update = ApplicationsInfo::where('id', '=', $app_id)->update([
                'app_arrangement' => $app_arrangement
            ]);
        }
        return "success";
    }

    public function deleteAjax(Request $request)
    {
        $app = ApplicationsInfo::find($request->app_id);
        if($app->count() != 0) {
            $getAppFormGorups = $app->applications()->get();

            // Delete App From groups
            foreach ($getAppFormGorups as $groupsApp){
                $folder = $groupsApp->groups->folder;
                $deleteIPA = File::delete(storage_path('app/public/store/_groups/'.$folder.'/'.$groupsApp->app_ipa));
            }
            // Delete App Form Info + icon
            $deleteAPP = File::deleteDirectory(storage_path('app/private/store/_applications_default/'.$app->app_folder.''));
            $deleteIcon = File::delete(storage_path('app/public/store/_icon/'.$app->app_ipa.'.png'));
            // Delete Form Database
            $app->delete();
        }

        return response()->json([
            'status' => 'true',
            'app' => $app,
        ]);
    }

    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }


    public function downloadStore(Request $request)
    {

    }
}
