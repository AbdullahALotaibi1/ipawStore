<?php

namespace App\Helpers;

use App\ConstantsHelper;

class EncryptHelper {

    public static function Encrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = ConstantsHelper::STORE_KEY;
        $secret_iv = ConstantsHelper::STORE_KEY_IV;
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public static function Decrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = ConstantsHelper::STORE_KEY;
        $secret_iv = ConstantsHelper::STORE_KEY_IV;
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }


}
