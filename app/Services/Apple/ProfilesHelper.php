<?php

namespace App\Services\Apple;

use App\AppleAccount;
use App\Group;
use App\Helpers\EncryptHelper;
use Illuminate\Support\Facades\Redirect;

class ProfilesHelper {

    public static function getListProfiles($cookie, $teamID)
    {

        // Setup return value
        $returnValue = array(
            'success' => false,
            'profile_id' => '',
        );

        // post json fields
        $fields = '{"urlEncodedQueryParams":"limit=1000&fields[profiles]=name,platform,platformName,profileTypeLabel,expirationDate,profileState&sort=name","teamId":"'.$teamID.'"}';

        // headers
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'Content-Type: application/vnd.api+json';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';
        $headers[] = 'X-Requested-With: XMLHttpRequest';
        $headers[] = 'X-HTTP-Method-Override: GET';

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$servicesAccountUrl.'profiles',
            '',
            $fields,
            $headers
        );

        // convert request to json
        $response = json_decode($request, true);

        // check session account
        if(isset($response['data'])){
            $returnValue['success'] = true;
            $returnValue['profile_id'] = $response['data'][0]['id'];
        }

        return $returnValue;
    }

    public static function registerAllDevicesAnProfile($cookie, $teamID)
    {
        // get profile id
        $responseProfile = self::getListProfiles($cookie, $teamID);
        $responseDevices = DevicesHelper::getListDevices($cookie, $teamID);

        // get devices id

        // Setup return value
        $returnValue = array(
            'success' => false,

        );

        // http_build_query
        $fields = http_build_query([
            'provisioningProfileId' => $responseProfile['profile_id'],
            'teamId' => $teamID,
            'includeInactiveProfiles' => true,
        ]);

        // headers
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'X-Requested-With: XMLHttpRequest';
        $headers[] = 'X-HTTP-Method-Override: GET';
        $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';


        // new request
        $request = RequestHelper::request(
            'https://developer.apple.com/services-account/QH65B2/account/ios/profile/getProvisioningProfile.action',
            '',
            $fields,
            $headers
        );

        $response = json_decode($request, true);

        if(isset($response['resultString']))
        {
            if(isset($response['resultString']) == 'Your session has expired.  Please log in.')
            {
                $returnValue['success'] = false;
                $returnValue['message'] = 'الرجاء تجديد تسجيل دخول لحساب المطورين الخاص بالمجموعة المحددة';
            }else{
                $returnValue['success'] = false;
                $returnValue['message'] = 'توجد مشكلة في حساب المطورين الرجاء التواصل مع مطور السكربت لحل الخطاء.';
            }
        }else{
            $returnValue['success'] = true;
            $returnValue['appIdId'] = $response['provisioningProfile']['appIdId'];
            $returnValue['provisioningProfileId'] = $response['provisioningProfile']['provisioningProfileId'];
            $returnValue['provisioningProfileName'] = $response['provisioningProfile']['name'];
            $returnValue['certificateId'] = $response['provisioningProfile']['certificates'][0]['certificateId'];
        }

        if($returnValue['success'] == true)
        {
            return self::regenProvisioningProfile($returnValue, $cookie, $teamID, $responseDevices);
        }

        return $returnValue;
    }

    public static function regenProvisioningProfile($returnValue, $cookie, $teamID, $responseDevices)
    {
        // Setup return value
        $returnEndValue = array(
            'success' => false,

        );

        // get csrf
        $responseCSRF = self::getCsrf($cookie, $teamID);

        if(isset($responseCSRF)){

        $devicesList = '';
        foreach ($responseDevices['devices'] as $key => $device)
        {
            if($key == 0){
                $devicesList = $devicesList.''.$device['device_id'];
            }
            $devicesList = $devicesList.','.$device['device_id'];
        }


        // Setup return value

        // headers
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'csrf: '.$responseCSRF['csrf'].'';
        $headers[] = 'csrf_ts: '.$responseCSRF['csrf_ts'].'';
        $headers[] = 'Sec-Fetch-Mode: cors';
        $headers[] = 'Host: developer.apple.com';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';


            $fields = http_build_query([
            'appIdId' => $returnValue['appIdId'],
            'provisioningProfileId' => $returnValue['provisioningProfileId'],
            'distributionType' => 'adhoc',
            'subPlatform' => '',
            'returnFullObjects' => 'false',
            'provisioningProfileName' => $returnValue['provisioningProfileName'],
            'certificateIds' => $returnValue['certificateId'],
            'deviceIds' => $devicesList, //'BU3G49A397,66XMS7C4GB,GL65F8YKD3,JM7WT2J2KY,2384HWK927,M4NYNMSN25,49NFDK53UY',
            'teamId' => $teamID,
        ]);

        // new request
        $request = RequestHelper::request(
            'https://developer.apple.com/services-account/QH65B2/account/ios/profile/regenProvisioningProfile.action',
            '',
            $fields,
            $headers
        );

            $response = json_decode($request, true);

            // Download New Profile
            $profile_id = $response['provisioningProfile']['provisioningProfileId'];
            return self::downloadProvisioningProfile($cookie, $teamID, $profile_id);
        }else{
            return $returnEndValue;
        }
    }

    public static function downloadProvisioningProfile($cookie, $teamID, $provisioningProfileId, $group_id = 0)
    {
        if($group_id == 0){
            $getFolderGroup = Group::where('team_id', '=', $teamID)->first()->folder;
        }else{
            $getFolderGroup = Group::where('id', '=', $group_id)->first()->folder;
        }
        if(!isset($getFolderGroup)){
            return Redirect::route('dashboard.home');
        }

        $dir ='private/store/_groups/'.$getFolderGroup.'/_files/profile.mobileprovision';

        // Setup return value
        $returnValue = array(
            'success' => false,
            'devices' => array(),
        );

        // headers
        $headers[] = '';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';


        // query
        $query = "teamId=$teamID&provisioningProfileId=$provisioningProfileId";

        // new request
        $request = RequestHelper::request(AppServicesHelper::$servicesBaseUrl.'ios/profile/downloadProfileContent?'.$query,
            '',
            [],
            $headers,
            true,
            0,
            $dir
        );

        return $request;
    }

    public static function getCsrf($cookie, $teamID)
    {

        // Setup return value
        $returnValue = array(
            'success' => false,
            'profile_id' => '',
        );

        // post json fields
        $fields = '{"urlEncodedQueryParams":"limit=1000&fields[profiles]=name,platform,platformName,profileTypeLabel,expirationDate,profileState&sort=name","teamId":"'.$teamID.'"}';

        // headers
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'Content-Type: application/vnd.api+json';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'X-Requested-With: XMLHttpRequest';
        $headers[] = 'X-HTTP-Method-Override: GET';
        $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';


        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$servicesAccountUrl.'profiles',
            '',
            $fields,
            $headers,
            1,
            1
        );

        if(isset($request)){
            $out = preg_split('/(\r?\n){2}/', $request, 2);
            $headers = $out[0];
            $headersArray = preg_split('/\r?\n/', $headers);
            $headersArray = array_map(function($h) {
                return preg_split('/:\s{1,}/', $h, 2);
            }, $headersArray);

            $tmp = [];
            foreach($headersArray as $h) {
                $tmp[strtolower($h[0])] = isset($h[1]) ? $h[1] : $h[0];
            }
            $headersArray = $tmp; $tmp = null;
            $returnValue['csrf_ts'] = $headersArray['csrf_ts'];
            $returnValue['csrf'] = $headersArray['csrf'];
            $returnValue['success'] = true;
        }

        return $returnValue;
    }
}


