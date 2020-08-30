<?php

namespace App\Helpers;

use App\ConstantsHelper;

class EncryptHelper {

    public static function Encrypt($data) {
        $encryption_key = base64_decode(ConstantsHelper::STORE_KEY);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0,
            $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function Decrypt($data) {
        $encryption_key = base64_decode(ConstantsHelper::STORE_KEY);
        list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data),
            2),2,null);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0,
            $iv);
    }
}
