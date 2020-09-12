<?php

namespace App\Services\Apple;

class DevicesHelper {

    public static function getListDevices($cookie, $teamID)
    {
        // Setup return value
        $returnValue = array(
            'success' => false,
            'devices' => array(),
        );

        // post json fields
        $fields = '{"urlEncodedQueryParams":"limit=1000&sort=name","teamId":"'.$teamID.'"}';

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
            AppServicesHelper::$servicesAccountUrl.'devices',
            $cookie,
            $fields,
            $headers
        );

        // convert request to json
        $response = json_decode($request, true);

        // check session account
        if(isset($response['data'])){
            $returnValue['success'] = true;
            foreach ($response['data'] as $key => $device){
                $returnValue['devices'][$key]['device_id'] = $device['id'];
                $returnValue['devices'][$key]['udid'] = $device['attributes']['udid'];
                $returnValue['devices'][$key]['added_date'] = $device['attributes']['addedDate'];
                $returnValue['devices'][$key]['model'] = $device['attributes']['model'];
                $returnValue['devices'][$key]['devicePlatform'] = $device['attributes']['devicePlatformLabel'];
            }
        }

        return $returnValue;
    }

    public static function addNewDevice($cookie, $teamID, $udid, $customerName)
    {

        // Setup return value
        $returnValue = array(
            'success' => false,
        );

        // get csrf
        $responseCSRF = ProfilesHelper::getCsrf($cookie, $teamID);

        if(isset($responseCSRF)) {
            $headers[] = 'Accept: application/json, text/plain, */*';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'Accept-Encoding: gzip, deflate, br';
            $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
            $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'csrf: ' . $responseCSRF['csrf'] . '';
            $headers[] = 'csrf_ts: ' . $responseCSRF['csrf_ts'] . '';
            $headers[] = 'Sec-Fetch-Mode: cors';
            $headers[] = 'Host: developer.apple.com';
            $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';


            // http_build_query
            $fields = http_build_query([
                'deviceNames' => $customerName,
                'deviceNumbers' => $udid,
                'devicePlatforms' => 'ios',
                'register' => 'single',
                'teamId' => $teamID,
            ]);

            // new request
            $request = RequestHelper::request(
                'https://developer.apple.com/services-account/QH65B2/account/device/addDevices.action',
                '',
                $fields,
                $headers
            );

            // convert request to json
            $response = json_decode($request, true);

            if(isset($response['devices']))
            {
                if(count($response['devices']) != 0){
                   return ProfilesHelper::registerAllDevicesAnProfile($cookie ,$teamID);
                }else{
                    $returnValue['message'] = "هذا الجهاز مسجل في حساب المطورين. او ان udid مكتوب بطريقة خاطئة";
                }
            }else{
                $returnValue['message'] = "هذا الجهاز مسجل في حساب المطورين. او ان udid مكتوب بطريقة خاطئة";
            }

            return $returnValue;

        }else{
            return $returnValue;
        }

    }

    public static function validateDevices($cookie, $teamID, $udid, $customerName)
    {

        // Setup return value
        $returnValue = array(
            'success' => false,
        );

        // get csrf
        $responseCSRF = ProfilesHelper::getCsrf($cookie, $teamID);

        if(isset($responseCSRF)) {
            $headers[] = 'Accept: application/json, text/plain, */*';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'Accept-Encoding: gzip, deflate, br';
            $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537';
            $headers[] = 'Accept-Language: ar,en-US;q=0.9,en;q=0.8';
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'csrf: ' . $responseCSRF['csrf'] . '';
            $headers[] = 'csrf_ts: ' . $responseCSRF['csrf_ts'] . '';
            $headers[] = 'Sec-Fetch-Mode: cors';
            $headers[] = 'Host: developer.apple.com';
            $headers[] = 'Cookie: myacinfo='.$cookie['myacinfo'].'';


            // http_build_query
            $fields = http_build_query([
                'deviceNames' => $customerName,
                'deviceNumbers' => $udid,
                'devicePlatforms' => 'ios',
                'register' => 'single',
                'teamId' => $teamID,
            ]);


            // new request
            $request = RequestHelper::request(
                'https://developer.apple.com/services-account/QH65B2/account/device/validateDevices.action',
                '',
                $fields,
                $headers
            );

            // convert request to json
            $response = json_decode($request, true);

            if(isset($response['devices']))
            {
                if(count($response['devices']) != 0){
                    return self::addNewDevice($cookie, $teamID, $udid, $customerName);
                }else{
                    $returnValue['message'] = "هذا الجهاز مسجل في حساب المطورين. او ان udid مكتوب بطريقة خاطئة";
                }
            }else{
                $returnValue['message'] = "هذا الجهاز مسجل في حساب المطورين. او ان udid مكتوب بطريقة خاطئة";
            }

            return $returnValue;
        }

        return $returnValue;
    }

}
