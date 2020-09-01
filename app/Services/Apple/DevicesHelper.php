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
                $returnValue['devices'][$key]['udid'] = $device['attributes']['udid'];
                $returnValue['devices'][$key]['model'] = $device['attributes']['model'];
                $returnValue['devices'][$key]['devicePlatform'] = $device['attributes']['devicePlatformLabel'];
            }
        }

        return $returnValue;
    }
}
