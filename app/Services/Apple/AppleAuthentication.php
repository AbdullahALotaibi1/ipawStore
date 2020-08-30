<?php

namespace App\Services\Apple;


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
        // Setup return value
        $returnValue = array(
            'success' => false,
            'errorMessage' => '',
            'scnt' => '',
            'codeReception' => $codeReception
        );

        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);

        // new request
        $request = RequestHelper::request(AppServicesHelper::$loginBaseUrl.'authenticate', [
            'appIdKey' => AppServicesHelper::$appIdKey,
            'accNameLocked' => 'false',
            'language' => AppServicesHelper::$userLocale,
            'Env' => 'PROD',
            'appleId' => $email,
            'accountPassword' => $password],
            [],
            false,
            $cookieDir
        );

        // Check for errors
        $checkForErrors = RequestHelper::checkForErrors($request);
        if ($checkForErrors['error'] == true) {
            $returnValue['errorMessage'] = $checkForErrors['errorMessage'];
        } else {
            // Success Login + get scnt code
            $returnValue['success'] = true;
            $returnValue['scnt'] = RequestHelper::getScntCode($request);
        }

        // send sms code to your phone
        if($returnValue['codeReception'] == 2){
            return self::performGetPhoneNumbers($returnValue['scnt'], $email);
        }else{
            return $returnValue;
        }
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

        // new request
        $request = RequestHelper::request(AppServicesHelper::$loginBaseUrl.'showTrustedPhoneNumbers', [
            'appIdKey' => AppServicesHelper::$appIdKey,
            'scnt' => $scnt],
            [],
            false,
            $cookieDir
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
//        return /**/

        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);

        // Setup return value
        $returnValue = array(
            'success' => false,
            'scnt' => ''
        );

        // new request
        $request = RequestHelper::request(AppServicesHelper::$loginBaseUrl.'generateSecurityCode', [
            'appIdKey' => AppServicesHelper::$appIdKey,
            'hsa2User' => true,
            'txtMode' => 'hsa2_sms',
            'deviceIndex' => $deviceID,
            'scnt' => $scnt],
            [],
            false,
            $cookieDir
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

        // new request
        $request = RequestHelper::request(AppServicesHelper::$loginBaseUrl.'validateSecurityCode', [
            'digit1' => substr($code, 0, 1),
            'digit2' => substr($code, 1, 1),
            'digit3' => substr($code, 2, 1),
            'digit4' => substr($code, 3, 1),
            'digit5' => substr($code, 4, 1),
            'digit6' => substr($code, 5, 1),
            'scnt' => $scnt,
            'fdcBrowserData' => '',
            'rememberMeSelected' => 'true'],
            [],
            false,
            $cookieDir,
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
            // Success Login
            $returnValue['success'] = true;
            $returnValue['cookies'] = $cookies;
            // Create Json File And Save User Cookie
            $cookieJson =  CookiesHelper::getCookiesJson($email, $cookies);
        } else {
            $returnValue['errorMessage'] = 'Incorrect verification code';
            $returnValue['scnt'] = RequestHelper::getScntCode($request);
        }


        // return
        return $returnValue;
    }




}
