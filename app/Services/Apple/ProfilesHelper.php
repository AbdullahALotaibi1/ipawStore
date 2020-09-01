<?php

namespace App\Services\Apple;

use App\AppleAccount;
use App\Helpers\EncryptHelper;
use Illuminate\Support\Facades\Redirect;

class ProfilesHelper {

    public static function getListProfiles($email, $teamID)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);
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

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$servicesAccountUrl.'profiles',
            $cookieDir,
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

    public static function downloadProvisioningProfile($email, $teamID, $provisioningProfileId)
    {

        $appleAccount = AppleAccount::where('apple_email', '=', EncryptHelper::Encrypt($email))->get()->first();
        if(!isset($appleAccount)){
            return Redirect::route('dashboard.groups.create');
        }
        $getFolderGroup = $appleAccount->groups()->first()->folder;

        // storage/5f4d647cedb4c
        $dir = storage_path('app/private/store/_groups/'.$getFolderGroup.'/_files/profile.mobileprovision');

        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);
        // Setup return value
        $returnValue = array(
            'success' => false,
            'devices' => array(),
        );

        // headers
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Connection: keep-alive';

        // query
        $query = "teamId=$teamID&provisioningProfileId=$provisioningProfileId";

        // new request
        $request = RequestHelper::request(AppServicesHelper::$servicesBaseUrl.'ios/profile/downloadProfileContent?'.$query,
            $cookieDir,
            [],
            $headers,
            true,
            0,
            $dir
        );

        return $request;
    }
}
