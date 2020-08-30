<?php

namespace App\Services\Apple;

use Illuminate\Support\Facades\Storage;

class CookiesHelper {

    public static function getCookiesFile($email)
    {
        $fileCookies = "private/apple/cookies/".$email."/cookies.txt";
        // Check exists folder
        if(!Storage::exists($fileCookies)) {
            Storage::put($fileCookies, ''); // create cookies file
        }
        return storage_path('app/'.$fileCookies);
    }

    public static function getCookiesJson($email, $content = '')
    {
        $fileCookies = "private/apple/cookies/".$email."/cookies.json";
        // Check exists folder
        if(!Storage::exists($fileCookies)) {
            Storage::put($fileCookies, $content); // create cookies file
        }
        return storage_path('app/'.$fileCookies);
    }


}
