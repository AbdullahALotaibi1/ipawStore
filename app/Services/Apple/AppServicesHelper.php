<?php

namespace App\Services\Apple;

class AppServicesHelper {
    /**
     * @desc All base links to Apple
     * @access public
     */
    public static $loginBaseUrl = "https://idmsa.apple.com/IDMSWebAuth/";
    public static $servicesBaseUrl = "https://developer.apple.com/services-account/QH65B2/account/";
    public static $servicesAccountUrl = "https://developer.apple.com/services-account/v1/";

    /**
     * @var string
     * @access public
     */
    public static $userAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537";

    /**
     * @var string
     * @access public
     */
    public static $userLocale = 'US-EN';

    /**
     * @var string
     * @access public
     */
    public static $appIdKey = "891bd3417a7776362562d2197f89480a8547b108fd934911bcbea0110d07f757";

    /**
     * @var string
     * @access public
     */
    public static $csrf;

    /**
     * @var string
     * @access public
     */
    public static $csrf_ts;

    /**
     * @var array
     * @access public
     */
    public static $headers = [
        'Accept: application/json, text/plain, */*',
        'Content-Type: application/vnd.api+json',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: ar,en-US;q=0.9,en;q=0.8',
        'Connection: keep-alive',
        'X-Requested-With: XMLHttpRequest',
        'X-HTTP-Method-Override: GET'
    ];
}
