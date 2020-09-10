<?php

namespace App\Services\Apple;

class DevicesHelper {

    public static function getListDevices($email, $teamID)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);
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
//        $headers[] = 'Cookie: myacinfo=DAWTKNV2f32047d0a3e4c0a0d914b5d1fec9ce9d05c26136553c725970421cfef5b0ed2ae1dde294acd0d4a6dbe977e97a4cc455e3c0b9fbe7150ed28ed52dcc64b6d6d93d52239beed58f3213ee71c599f9011ab7f27f5a6217395ce1563b1dccbfe1f9c208f0bd5b6e192b989da73d813bf54a10b321703812ea09c93585726b60ad8170ed58631a5afc020f7e1c44f93d4f5c8526630ba6d6ec692d7c840b778aab7dcad2b9694443cbe2e0cc05bbdc72e0acc14e58b5ccdf43984f100ef992dd63bd0c9f32e7308c5ed8b1d7db73326c57d8b36c692fe5c6232c6c10a9b9ef6eb879ff7dde0ef7ea1d1f1840da12b1f88194f01882cf764ccfe7e3ab4dd1983f07edc778f6e1b60ac86ea2f16972364dd064cd953b7f874ac6863926e9618f93bee5e7b477893107277efd00a88d76bccabca1d9db95a7efee8b7f018d2bac5aad627226f92b94deabda56a33f9e807b26ee15adefc3d6c7add4fd0326c99fb5dfd72b8b4293dbb962f7c06f04d8a7b39ff28374457325551c1af4e7742dceb459e319b741baf97251d8b84700cb592ad4b9c5cb13c9d3ad45dd275d2f089ae2fd14e9b89190d9f91e971c48f95105795934245036b516c1e8c2b0f58be6dfc8a72b259c5308bb091fe4227f8ef991583c1bd0cc38933767af1022129e7a350c3e8010e43d4a37103e47c177bdd7913c559996eb6494342b0fb70df1b0ba2b83e24a992c9e2f3176616ba4d0aa53cf1655d561626434323836393662326232386431623332303961613866346636333938663130356436616132MVRYV2';
        $headers[] = 'X-Requested-With: XMLHttpRequest';
        $headers[] = 'X-HTTP-Method-Override: GET';

        // new request
        $request = RequestHelper::request(
            AppServicesHelper::$servicesAccountUrl.'devices',
            $cookieDir,
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

    public static function addNewDevice($email, $teamID, $udid, $customerName)
    {

        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);
        // Setup return value
        $returnValue = array(
            'success' => false,
        );

        // get csrf
        $responseCSRF = ProfilesHelper::getCsrf($email, $teamID);

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
                $cookieDir,
                $fields,
                $headers
            );

            // convert request to json
            $response = json_decode($request, true);

            if(isset($response['devices']))
            {
                if(count($response['devices']) != 0){
                   return ProfilesHelper::registerAllDevicesAnProfile($email ,$teamID);
                }else{
                    $returnValue['message'] = "هذا الجهاز مسجل في حساب المطورين. او ان udid مكتوب بطريقة خاطئة";
                }
            }else{
                $returnValue['message'] = "هذا الجهاز مسجل في حساب المطورين. او ان udid مكتوب بطريقة خاطئة";
            }

            return $returnValue;

        }else{
            return "fds";
        }

    }

    public static function validateDevices($email, $teamID, $udid, $customerName)
    {
        // get cookie file
        $cookieDir = CookiesHelper::getCookiesFile($email);
        // Setup return value
        $returnValue = array(
            'success' => false,
        );

        // get csrf
        $responseCSRF = ProfilesHelper::getCsrf($email, $teamID);

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
                $cookieDir,
                $fields,
                $headers
            );

            // convert request to json
            $response = json_decode($request, true);

            if(isset($response['devices']))
            {
                if(count($response['devices']) != 0){
                    return self::addNewDevice($email, $teamID, $udid, $customerName);
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
