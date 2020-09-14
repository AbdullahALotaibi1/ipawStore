<?php

namespace App\Services\Apple;
use App\Group;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class APCore {

    /**
     * @var Client
     * @access public
     */
    public $client;

    /**
     * @var string
     * @access public
     */
    public $loginBaseUrl = "https://idmsa.apple.com/IDMSWebAuth/";

    /**
     * @var string
     * @access public
     */
    public $listTeamBaseUrl = "https://developer.apple.com/services-account/QH65B2/account/";

    /**
     * @var string
     * @access public
     */
    public $servicesBaseUrl = "https://developer.apple.com/services-account/v1/";




    /**
     * @var string
     * @access public
     */
    public $app_id_key = "891bd3417a7776362562d2197f89480a8547b108fd934911bcbea0110d07f757";


    /**
     * @var string
     * @access public
     */
    public $userAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537";


    public function performLogin($email, $password, $cookie = [], $toSMS = 1)
    {
        $returnValue = ["success" => false];
        try {
            $cookieJar = CookieJar::fromArray($cookie != null ? $cookie : [], 'apple.com');
            $this->client = new Client(['base_uri' => $this->loginBaseUrl]);
            $response = $this->client->request(
                "POST",
                "authenticate",
                [
                    'query' => [
                        'appIdKey' => $this->app_id_key,
                        'accNameLocked' => 'false',
                        'Env' => 'PROD',
                        'appleId' => $email,
                        'accountPassword' => $password
                    ],
                    'verify' => true,
                    'cookies' => $cookieJar,
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                        'User-Agent' => $this->userAgent,
                        'Accept-Language' => 'en-us',
                    ],
                    'allow_redirects' => false
                ]
            );

            // MARK: - success login
            if ($response->getStatusCode() == '302') {
                $loginCookies = [];
                foreach ($response->getHeader('Set-Cookie') as $sCookie){
                    parse_str($sCookie, $result);
                    $loginCookies = array_merge($loginCookies, $result);
                }
                if(isset($loginCookies['myacinfo']))
                {
                    $returnValue['success'] = true;
                    $returnValue['myacinfo'] = $loginCookies['myacinfo'];
                    return $returnValue;
                }else{
                    $returnValue['success'] = false;
                    return $returnValue;
                }
            }

            $body = $response->getBody();

            // MARK: - Two-Factor Or incorrectly data
            // MARK: - Check for errors
            $checkForErrors = RequestHelper::checkForErrors($body);
            if ($checkForErrors['error'] == true) {
                $returnValue['errorMessage'] = $checkForErrors['errorMessage'];
                return $returnValue;
            }else{
                $JSSCookies = [];
                foreach ($response->getHeader('Set-Cookie') as $sCookie){
                    parse_str($sCookie, $result);
                    $JSSCookies = array_merge($JSSCookies, $result);
                }

                // Success Login + get scnt code
                $returnValue['success'] = true;
                $returnValue['cookies'] = $JSSCookies;
                $returnValue['scnt'] = RequestHelper::getScntCode($body);
            }
            // MARK: - Two-Factor
            if($toSMS == 2){
                return $this->performGetPhoneNumbers($returnValue['scnt'], $returnValue['cookies']);
            }

            return $returnValue;
        } catch (RequestException $e) {
            // Log exception here
            $returnValue['errorMessage'] = $e->getMessage();
            return $returnValue;
        }
    }

    public function performGetPhoneNumbers($scnt, $cookie = [])
    {
        $returnValue = ["success" => false];
        try {
            $cookieJar = CookieJar::fromArray($cookie != null ? $cookie : [], 'apple.com');
            $this->client = new Client(['base_uri' => $this->loginBaseUrl]);
            $response = $this->client->request(
                "POST",
                "showTrustedPhoneNumbers",
                [
                    'query' => [
                        'appIdKey' => $this->app_id_key,
                        'scnt' => $scnt,
                    ],
                    'verify' => true,
                    'cookies' => $cookieJar,
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                        'User-Agent' => $this->userAgent,
                        'Accept-Language' => 'en-us',
                    ],
                    'allow_redirects' => false
                ]
            );

            if ($response->getStatusCode() == '200') {
                $body = $response->getBody();
                $returnValue['devices'] = StringHelper::getPhoneNumbers($body);
                $returnValue['scnt'] = RequestHelper::getScntCode($body);
            }
            if(isset($returnValue['devices']))
            {
                if($returnValue['devices'] != null){
                    $JSSCookies = [];
                    foreach ($response->getHeader('Set-Cookie') as $sCookie){
                        parse_str($sCookie, $result);
                        $JSSCookies = array_merge($JSSCookies, $result);
                    }
                    $JSSCookies = array_merge($JSSCookies, $cookie);
                    $returnValue['success'] = true;
                    $returnValue['cookies'] = $JSSCookies;
                    return $returnValue;
                }else{
                    return $returnValue;
                }
            }else{
                return $returnValue;
            }

            return $returnValue;
        } catch (RequestException $e) {
            // Log exception here
            $returnValue['errorMessage'] = $e->getMessage();
            return $returnValue;
        }
    }

    public function performSendSecurityCode($scnt, $deviceID, $cookie = [])
    {
        $returnValue = ["success" => false];
        try {
            $cookieJar = CookieJar::fromArray($cookie != null ? $cookie : [], 'apple.com');
            $this->client = new Client(['base_uri' => $this->loginBaseUrl]);
            $response = $this->client->request(
                "POST",
                "generateSecurityCode",
                [
                    'query' => [
                        'appIdKey' => $this->app_id_key,
                        'hsa2User' => true,
                        'txtMode' => 'hsa2_sms',
                        'deviceIndex' => $deviceID,
                        'scnt' => $scnt,
                    ],
                    'verify' => true,
                    'cookies' => $cookieJar,
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                        'User-Agent' => $this->userAgent,
                        'Accept-Language' => 'en-us',
                    ],
                    'allow_redirects' => false
                ]
            );

            if ($response->getStatusCode() == '200') {
                $body = $response->getBody();
                $returnValue['success'] = true;
                $returnValue['cookies'] = $cookie;
                $returnValue['scnt'] = RequestHelper::getScntCode($body);
            }


            return $returnValue;
        } catch (RequestException $e) {
            // Log exception here
            $returnValue['errorMessage'] = $e->getMessage();
            return $returnValue;
        }
    }

    public function performValidateSecurityCode($scnt, $code, $cookie = [])
    {
        $returnValue = ["success" => false];
        try {
            $cookieJar = CookieJar::fromArray($cookie != null ? $cookie : [], 'apple.com');
            $this->client = new Client(['base_uri' => $this->loginBaseUrl]);
            $response = $this->client->request(
                "POST",
                "validateSecurityCode",
                [
                    'query' => [
                        'digit1' => substr($code, 0, 1),
                        'digit2' => substr($code, 1, 1),
                        'digit3' => substr($code, 2, 1),
                        'digit4' => substr($code, 3, 1),
                        'digit5' => substr($code, 4, 1),
                        'digit6' => substr($code, 5, 1),
                        'scnt' => $scnt,
                        'fdcBrowserData' => '',
                        'rememberMeSelected' => 'true'
                    ],
                    'verify' => true,
                    'cookies' => $cookieJar,
                    'headers' => [
                        'X-Requested-With' => 'XMLHttpRequest',
                        'User-Agent' => $this->userAgent,
                        'Accept-Language' => 'en-us',
                    ],
                    'allow_redirects' => false
                ]
            );

            // MARK: - success login
            if ($response->getStatusCode() == '302') {
                $loginCookies = [];
                foreach ($response->getHeader('Set-Cookie') as $sCookie){
                    parse_str($sCookie, $result);
                    $loginCookies = array_merge($loginCookies, $result);
                }
                if(isset($loginCookies['myacinfo']))
                {
                    foreach($loginCookies as $key => $str) {
                        if(strpos($key,'DES') !== false) {
                            $mystring = 'home/cat1/subcat2/';
                            $rememberKey = strtok($str, ';');
                            $loginRememberKey = str_replace(' ', '+', $rememberKey);
                            $returnValue['loginRememberKey'] = $key;
                            $returnValue['loginRememberValue'] = $loginRememberKey;
                        }
                    }

                    $returnValue['success'] = true;
                    $returnValue['myacinfo'] = $loginCookies['myacinfo'];
                    $returnValue['headers'] = $response->getHeaders();
                    return $returnValue;
                }else{
                    $returnValue['success'] = false;
                    return $returnValue;
                }
            }else{
                $body = $response->getBody();
                $returnValue['errorMessage'] = 'Incorrect verification code';
                $returnValue['scnt'] = RequestHelper::getScntCode($body);
                return $returnValue;
            }

            return $returnValue;
        } catch (RequestException $e) {
            // Log exception here
            $returnValue['errorMessage'] = $e->getMessage();
            return $returnValue;
        }
    }

    public function getAccountInfo($cookie = [], $group_id = 0)
    {
        $returnValue = ["success" => false];
        try {
            $cookieJar = CookieJar::fromArray($cookie != null ? $cookie : [], 'apple.com');
            $this->client = new Client(['base_uri' => $this->listTeamBaseUrl]);
            $response = $this->client->request(
                "POST",
                "getTeams",
                [
                    'query' => [
                        '{"includeInMigrationTeams":1}'
                    ],
                    'verify' => true,
                    'cookies' => $cookieJar,
                    'headers' => [
                        'User-Agent' => $this->userAgent,
                        'Accept-Language' => 'en-us',
                        'Content-Type' => 'application/json',
                        'Connection' => 'keep-alive'
                    ],
                    'allow_redirects' => false
                ]
            );

            $teams = $response->getBody();
            $jsonTeams = json_decode($teams, true);
            if(!isset($jsonTeams['teams'])){
                $returnValue['errorMessage'] = ' الرجاء اعادة تسجيل الدخول لحساب المطورين';
                return $returnValue;
            }

            $resDevices = DevicesHelper::getListDevices($cookie, $jsonTeams['teams'][0]['teamId']);
            $resProfiles = ProfilesHelper::getListProfiles($cookie, $jsonTeams['teams'][0]['teamId']);
            $resDownload = ProfilesHelper::downloadProvisioningProfile($cookie, $jsonTeams['teams'][0]['teamId'], $resProfiles['profile_id'], $group_id);

            // prepare data
            $returnValue['success'] = true;
            $returnValue['team_id'] = $jsonTeams['teams'][0]['teamId'];
            $returnValue['date_expires'] = $jsonTeams['teams'][0]['program']['dateExpires'];
            $returnValue['registered_devices'] = $resDevices['devices'];
            $returnValue['profiles_development'] = $resProfiles;
            $returnValue['profile_downloaded'] = $resDownload == 'success_download' ? true : false;

            return $returnValue;
        } catch (RequestException $e) {
            // Log exception here
            $returnValue['errorMessage'] = $e->getMessage();
            return $returnValue;
        }
    }


    public function downloadProfile($profileId, $teamID, $cookie = [], $group_id = 0)
    {
        if($group_id == 0){
            $getFolderGroup = Group::where('team_id', '=', $teamID)->first()->folder;
        }else{
            $getFolderGroup = Group::where('id', '=', $group_id)->first()->folder;
        }
        if(!isset($getFolderGroup)){
            return Redirect::route('dashboard.home');
        }

        $returnValue = ["success" => false];
        try {
            $cookieJar = CookieJar::fromArray($cookie != null ? $cookie : [], 'apple.com');
            $this->client = new Client(['base_uri' => $this->listTeamBaseUrl]);
            $response = $this->client->request(
                "GET",
                "ios/profile/downloadProfileContent",
                [
                    'query' => [
                        'provisioningProfileId' => $profileId,
                        'teamId' => $teamID,
                    ],
                    'verify' => true,
                    'cookies' => $cookieJar,
                    'headers' => [
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                        'User-Agent' => $this->userAgent,
                        'Accept-Language' => 'en-us',
                    ],
                    'allow_redirects' => false
                ]
            );

            $dir ='private/store/_groups/'.$getFolderGroup.'/_files/profile.mobileprovision';
            $download = Storage::put($dir, $response->getBody());

            if(isset($download))
            {
                return "success_download";
            }

            return $returnValue;
        } catch (RequestException $e) {
            // Log exception here
            $returnValue['errorMessage'] = $e->getMessage();
            return $returnValue;
        }
    }


}
