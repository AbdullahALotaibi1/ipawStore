<?php

namespace App\Http\Controllers\Dashboard;

use App\ApplicationsInfo;
use App\ConstantsHelper;
use App\Group;
use App\Http\Controllers\Controller;
use App\Services\Ipa\IpaHelper;
use Illuminate\Http\Request;
use CFPropertyList\CFPropertyList;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ApplicationsInfoController extends Controller
{

    public function index()
    {


        return view('dashboard.applications.index');
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
            'app_icon' => 'icon.png',
            'app_arrangement' => '0',
            'app_size' => '0',
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
            $ipaRandomName = Str::random(40).'.ipa';
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
            $process = new Process($cmdLine);
            $process->run();
            $outPut = $process->getOutput();
            if(isset($outPut)){
                $getApp->applications()->create([
                    'group_id' => $group->id,
                    'app_plist' => 'sa',
                    'app_ipa' => $ipaRandomName
                ]);
                $returnValue['success'] = true;
                $returnValue['message'] = 'تم توقيع تطبيق ('.$getApp->app_name.') على كل مجموعات المتاحة';
                return $returnValue;
            }

            return $returnValue;
        }

    }
}
