<?php

namespace App\Services\Apple;

use Illuminate\Support\Facades\Storage;

class RequestHelper {

    public static function cURL($url = null, $cookies = '')
    {
        // Initialize a cURL session
        $cURL = curl_init($url);
        // Setup the appropriate cookie handling
        // Return the cURL session
        return $cURL;
    }

    public static function request($url, $cookies = '',$fields = [], $headers = [],$followLocation = false,  $header = 0, $downloadDir = '', $ENCODING = 1, $cookie = '')
    {
        // Open new cURL session
        $cURL = self::cURL($url, $cookies);

        // Return both response headers and body
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cURL, CURLOPT_HEADER, $header); // hide 0 / show 1
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, $followLocation);


        // fields
        if($fields != null) {
            // Setup cURL session POST fields
            if($cookie != '')
            {
                curl_setopt($cURL, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($cURL,CURLOPT_POST, 1);
            curl_setopt($cURL, CURLOPT_POSTFIELDS, $fields);
        }

        // headers
        if($headers != null){
            if($ENCODING == 1){
                curl_setopt($cURL, CURLOPT_ENCODING, "");
            }
            curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
        }

        if ($downloadDir != ''){
            curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
        }

        // Execute the cURL session
        $result = curl_exec($cURL);
        curl_close($cURL);

        // download
        if($downloadDir != ''){
            Storage::put($downloadDir, $result); // create cookies file
            return 'success_download';
        }
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
