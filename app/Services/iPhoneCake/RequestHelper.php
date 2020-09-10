<?php
namespace App\Services\iPhoneCake;

use Illuminate\Support\Facades\Storage;

class RequestHelper {

    public static function request($url, $downloadDir = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $result = curl_exec($ch);
        curl_close ($ch);

        if($downloadDir != ''){
            Storage::put($downloadDir, $result); // create cookies file
            return 'success_download';
        }

        return json_decode($result);
    }

    public static function downloadFile($url, $downloadDir = '')
    {
        ob_flush();
        flush();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array('self', 'progress'));


        curl_setopt($ch, CURLOPT_NOPROGRESS, false); // needed to make progress function work
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $result = curl_exec($ch);
        curl_close($ch);



        if($downloadDir != ''){
            Storage::put($downloadDir, $result); // create cookies file
            return 'success_download';
        }

        ob_flush();
        flush();

        return $result;
    }


    public static function progress($resource,$download_size, $downloaded, $upload_size, $uploaded)
    {
        if($download_size > 0)
        echo $downloaded / $download_size  * 100;
        ob_flush();
        flush();
        sleep(1); // just to see effect
    }

}
