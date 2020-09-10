<?php
namespace App\Services\iPhoneCake;

class iPhoneCake {
    public static function getListApp($page = 1, $device = 1)
    {
        // return value
        $returnValue = [
            'success' => false
        ];
        // make request
        $request = RequestHelper::request("https://apiv2.iphonecake.com/appcake/appcake_api/spv6/applist_r.php?device=$device&p=$page");

        $returnValue['success'] = true;
        $returnValue['data'] = $request;
        return $returnValue;
    }

    public static function appSearch($page = 1, $device = 1, $query = '')
    {
        // return value
        $returnValue = [
            'success' => false
        ];
        // make request
        $request = RequestHelper::request("https://apiv2.iphonecake.com/appcake/appcake_api/spv6/appsearch_r.php?device=$device&q=$query&p=$page");
        $returnValue['success'] = true;
        $returnValue['data'] = $request;
        return $returnValue;
    }

    public static function getIpaApp($appID)
    {
        // return value
        $returnValue = [
            'success' => false
        ];
        // make request
        $request = RequestHelper::request("https://apiv2.iphonecake.com/appcake/appcake_api/ipastore_ios_link.php?type=1&id=$appID");
        $returnValue['success'] = true;
        $returnValue['data'] = $request;
        return $returnValue;
    }
}
