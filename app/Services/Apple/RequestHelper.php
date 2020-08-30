<?php

namespace App\Services\Apple;

class RequestHelper {

    public static function cURL($url = null, $cookies)
    {
        // Initialize a cURL session
        $cURL = curl_init($url);
        // Setup the appropriate cookie handling
        curl_setopt($cURL, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt($cURL, CURLOPT_COOKIEJAR, $cookies);
        // Return the cURL session
        return $cURL;
    }

    public static function request($url, $fields = [], $headers = [], $followLocation = true, $cookies, $header = 0)
    {
        // Open new cURL session
        $cURL = self::cURL($url, $cookies);

        // Return both response headers and body
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cURL, CURLOPT_HEADER, $header); // hide 0 / show 1
        if($followLocation == true){
            curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        }

        // fields
        if($fields != null) {
            // Setup cURL session POST fields
            curl_setopt($cURL, CURLOPT_POSTFIELDS, http_build_query($fields));
        }

        // headers
        if($headers != null){
            curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
        }

        // Execute the cURL session
        $result = curl_exec($cURL);
        curl_close($cURL);

        return $result;
    }


    public static function checkForErrors($request)
    {
        // Setup return value
        $returnValue = array(
            'error' => false,
            'errorMessage' => '',
        );

        // Check for errors
        if (StringHelper::getErrorMessage($request, 'dserror') != '') {
            $returnValue['error'] = true;
            $returnValue['errorMessage'] = StringHelper::getErrorMessage($request, 'error');
        } else if (StringHelper::getErrorMessage($request, 'accountLocked') != '') {
            $returnValue['error'] = true;
            $returnValue['errorMessage'] = 'Account Changes Locked.';
        }else if (StringHelper::getErrorMessage($request, 'invalid-copy') != '') {
            $returnValue['error'] = true;
            $returnValue['errorMessage'] = 'Incorrect verification code';
        }

        return $returnValue;
    }

    public static function getScntCode($request)
    {
        return StringHelper::getStringBetween($request, '<input type="hidden" id="scnt" name="scnt" value="', '" />');
    }


}
