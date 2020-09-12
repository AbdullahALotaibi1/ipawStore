<?php

namespace App\Services\Apple;


use App\AppleAccount;
use App\Helpers\EncryptHelper;
use Illuminate\Support\Facades\File;

class AppleAuthentication {

    /**
     * @desc Login With Apple Developer Account
     * @param $email
     * @param $password
     * @param int $codeReception
     * @return array
     * */
    public static function preformLogin($email, $password, $codeReception = 1)
    {

        $getAppleData = AppleAccount::where('apple_email', '=', EncryptHelper::Encrypt($email));

        // Setup return value
        $returnValue = array(
            'success' => false,
            'errorMessage' => '',
            'scnt' => '',
            'codeReception' => $codeReception
        );

        $headers = [];
        $cookie = '';
        // MARK: - Delete Cookies file
        if($getAppleData->count() != 0) {
            $deleteCookies = File::deleteDirectory(storage_path('app/private/apple/cookies/'.EncryptHelper::Decrypt($getAppleData->first()->apple_email)));
            $login_remember_key = EncryptHelper::Decrypt($getAppleData->first()->login_remember_key);
            $login_remember_value = EncryptHelper::Decrypt($getAppleData->first()->login_remember_value);
            $cookie = ''.$login_remember_key.'='.$login_remember_value.'';
            $headers[] = 'Cookie: '.$cookie.'';
        }
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);


        // http_build_query
        $fields = http_build_query([
            'appIdKey' => AppServicesHelper::$appIdKey,
            'accNameLocked' => 'false',
            'language' => AppServicesHelper::$userLocale,
            'Env' => 'PROD',
            'appleId' => $email,
            'accountPassword' => $password
        ]);

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$loginBaseUrl.'authenticate',
            $cookieDir,
            $fields,
            $headers,
            true,
            1,
            '',
            1,
            $cookie
        );


        // Check for errors
        $checkForErrors = RequestHelper::checkForErrors($request);
        if ($checkForErrors['error'] == true) {
            $returnValue['errorMessage'] = $checkForErrors['errorMessage'];
        } else {
            $cookies = array();
            preg_match_all('/^Set-Cookie:\\s*([^;]*)/mi', $request, $matches);
            foreach ($matches[1] as $match) {
                parse_str($match, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }
            // Check for errors
            if (isset($cookies['myacinfo'])) {
                // Success Login
                $returnValue['success'] = true;
                $returnValue['myacinfo'] = $cookies['myacinfo'];
            } else {
                // Success Login + get scnt code
                $returnValue['success'] = true;
                $returnValue['scnt'] = RequestHelper::getScntCode($request);
            }
        }

        // send sms code to your phone
        if($returnValue['codeReception'] == 2 && !isset($cookies['myacinfo'])){
            return self::performGetPhoneNumbers($returnValue['scnt'], $email);
        }else{
            return $returnValue;
        }
    }


    public static function preformReLogin($email, $password)
    {

        $getAppleData = AppleAccount::where('apple_email', '=', EncryptHelper::Encrypt($email));

        // Setup return value
        $returnValue = array(
            'success' => false,
            'errorMessage' => '',
        );

        $headers = [];
        $group_id = 0;
        // MARK: - Delete Cookies file
        if($getAppleData->count() != 0) {
            $deleteCookies = File::deleteDirectory(storage_path('app/private/apple/cookies/'.EncryptHelper::Decrypt($getAppleData->first()->apple_email)));
            $login_remember_key = EncryptHelper::Decrypt($getAppleData->first()->login_remember_key);
            $login_remember_value = EncryptHelper::Decrypt($getAppleData->first()->login_remember_value);
            $cookie = ''.$login_remember_key.'='.$login_remember_value.'';
            $headers[] = 'Cookie: '.$cookie.'';
            $group_id = $getAppleData->first()->groups->id;
        }else{
            $cookie = '';
        }

        return $cookie;
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);


        // http_build_query
        $fields = http_build_query([
            'appIdKey' => AppServicesHelper::$appIdKey,
            'accNameLocked' => 'false',
            'language' => AppServicesHelper::$userLocale,
            'Env' => 'PROD',
            'appleId' => $email,
            'accountPassword' => $password
        ]);

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$loginBaseUrl.'authenticate',
            $cookieDir,
            $fields,
            $headers,
            true,
            1,
            '',
            1,
            $cookie
        );

        // Check for errors
        $checkForErrors = RequestHelper::checkForErrors($request);
        if ($checkForErrors['error'] == true) {
            $returnValue['errorMessage'] = $checkForErrors['errorMessage'];
        } else {
            $cookies = array();
            preg_match_all('/^Set-Cookie:\\s*([^;]*)/mi', $request, $matches);
            foreach ($matches[1] as $match) {
                parse_str($match, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }

            // Check for errors
            if (isset($cookies['myacinfo'])) {
                // Success Login
                $returnValue['success'] = true;
                $returnValue['myacinfo'] = $cookies['myacinfo'];
            } else {
                $returnValue['success'] = false;
                $returnValue['group_id'] = $group_id;
            }
        }

        return $returnValue;
    }
    /**
     * @desc Get your numbers phone
     * @param $scnt
     * @param $email
     * @return array
     * */
    public static function performGetPhoneNumbers($scnt, $email)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);

        // Setup return value
        $returnValue = array(
            'success' => false,
            'errorMessage' => '',
            'devices' => array(),
            'scnt' => ''
        );

        // http_build_query
        $fields = http_build_query([
            'appIdKey' => AppServicesHelper::$appIdKey,
            'scnt' => $scnt
        ]);

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$loginBaseUrl.'showTrustedPhoneNumbers',
            $cookieDir,
            $fields
        );


        $returnValue['devices'] = StringHelper::getPhoneNumbers($request);
        $returnValue['success'] = true;
        $returnValue['scnt'] = RequestHelper::getScntCode($request);

        return $returnValue;
    }

    /**
     * @desc Send Security Code for two-factor
     * @param $scnt
     * @param $deviceID
     * @param $email
     * @return array
     * */
    public static function performSendSecurityCode($scnt, $deviceID, $email)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);

        // Setup return value
        $returnValue = array(
            'success' => false,
            'scnt' => ''
        );

        // http_build_query
        $fields = http_build_query([
            'appIdKey' => AppServicesHelper::$appIdKey,
            'hsa2User' => true,
            'txtMode' => 'hsa2_sms',
            'deviceIndex' => $deviceID,
            'scnt' => $scnt
        ]);
        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$loginBaseUrl.'generateSecurityCode',
            $cookieDir,
            $fields
        );

        $returnValue['success'] = true;
        $returnValue['scnt'] = RequestHelper::getScntCode($request);

        // return devices
        return $returnValue;
    }

    /**
     * @desc Validate Security Code
     * @param $scnt
     * @param $code
     * @param $email
     * @return array
     * */
    public static function performValidateSecurityCode($scnt, $code, $email)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);

        // Setup return value
        $returnValue = array(
            'success' => false,
        );

        // http_build_query
        $fields = http_build_query([
            'digit1' => substr($code, 0, 1),
            'digit2' => substr($code, 1, 1),
            'digit3' => substr($code, 2, 1),
            'digit4' => substr($code, 3, 1),
            'digit5' => substr($code, 4, 1),
            'digit6' => substr($code, 5, 1),
            'scnt' => $scnt,
            'fdcBrowserData' => '',
            'rememberMeSelected' => 'true'
        ]);

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$loginBaseUrl.'validateSecurityCode',
            $cookieDir,
            $fields,
            [],
            false,
            1
        );


        $cookies = array();
        preg_match_all('/^Set-Cookie:\\s*([^;]*)/mi', $request, $matches);
        foreach ($matches[1] as $match) {
            parse_str($match, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }


        // Check for errors
        if (isset($cookies['myacinfo'])) {
            foreach($cookies as $key => $str) {
                if(strpos($key,'DES') !== false) {
                    $returnValue['loginRememberKey'] = $key;
                    $returnValue['loginRememberValue'] = $str;
                }
            }
            // Success Login
            $returnValue['success'] = true;
            $returnValue['cookies'] = $cookies;
            $returnValue['myacinfo'] = $cookies['myacinfo'];
            // Create Json File And Save User Cookie
            $cookieJson =  CookiesHelper::getCookiesJson($email, $cookies);
        } else {
            $returnValue['errorMessage'] = 'Incorrect verification code';
            $returnValue['scnt'] = RequestHelper::getScntCode($request);
        }


        // return
        return $returnValue;
    }

    public static function getAccountInfo($email)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);
        // Setup return value
        $returnValue = array(
            'success' => false,
            'team_id' => '',
            'date_expires' => 0,
            'registered_devices' => array(),
            'profiles_development' => array(),
            'profile_downloaded' => false
        );

        // post json fields
        $fields = '{"includeInMigrationTeams":1}';

        // headers
        $headers[] =  "Accept-Charset: utf-8;q=0.7,*;q=0.3";
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
        $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Proxy-Connection: keep-alive';
        $headers[] = 'Content-Length: 29';

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$servicesBaseUrl.'getTeams',
            $cookieDir,
            $fields,
            $headers
        );

        // convert request to json
        $response = json_decode($request, true);

        // check session account
        if(isset($response['teams'])){
            $resDevices = DevicesHelper::getListDevices($email, $response['teams'][0]['teamId']);
            $resProfiles = ProfilesHelper::getListProfiles($email, $response['teams'][0]['teamId']);
            $resDownload = ProfilesHelper::downloadProvisioningProfile($email, $response['teams'][0]['teamId'], $resProfiles['profile_id']);

            // prepare data
            $returnValue['success'] = true;
            $returnValue['team_id'] = $response['teams'][0]['teamId'];
            $returnValue['date_expires'] = $response['teams'][0]['program']['dateExpires'];
            $returnValue['registered_devices'] = $resDevices['devices'];
            $returnValue['profiles_development'] = $resProfiles;
            $returnValue['profile_downloaded'] = $resDownload == 'success_download' ? true : false;
        }


        return $returnValue;

    }


}
