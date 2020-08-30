<?php

namespace App\Services\Apple;

class StringHelper {
    public static function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function getErrorMessage($html, $className)
    {
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $finder = new \DomXPath($doc);
        $spanner = $finder->query("//*[contains(@class, '$className')]");
        if(is_object($spanner[0])) {
            return $spanner[0]->nodeValue;
        }
        return "";
    }


    public static function getPhoneNumbers($html)
    {
        $devices = array();
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $finder = new \DomXPath($doc);
        $spanner = $finder->query("//*[contains(@class, 'formrow')]");
        foreach ($spanner as $key => $device){
            $devices[] = array(
                'deviceID' => $key+1,
                'devicesText' => $device->nodeValue,
            );
        }
        return $devices;
    }
}
