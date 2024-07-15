<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;
use PG\Request\Request;

$path = dirname(__FILE__);
require $path . '/vendor/autoload.php';

// Add mycaasify if exist
$MyCaasifyAddress = $path . '/mycaasify.php';
if (file_exists($MyCaasifyAddress)) {
    include($MyCaasifyAddress);
}

function caasify_get_mycaasify_status(){
    global $MyCaasifyIsEnabled;
    if(!isset($MyCaasifyIsEnabled) || $MyCaasifyIsEnabled != true){
        return 'off';
    }
    return 'on';
}

function caasify_has_array($name, $array){
    if (array_key_exists($name, $array)) {
        return true;
    }
    return false;
}

function caasify_get_array($name, $array){
    if (caasify_has_array($name, $array)) {
        return $array[$name];
    }
    return null;
}

function caasify_has_query($name){
    if (caasify_has_array($name, $_GET)) {
        return true;
    }
    return false;
}

function caasify_get_query($name){
    if (caasify_has_query($name)) {
        return $_GET[$name];
    }
    return null;
}

function caasify_has_post($name){
    if (caasify_has_array($name, $_POST)) {
        return true;
    }
    return false;
}

function caasify_get_post($name){
    if (caasify_has_post($name)) {
        return $_POST[$name];
    }
    return null;
}

function caasify_get_post_array($names)
{
    $params = [];
    foreach($names as $name) {
        $params[$name] = caasify_get_post($name);
    }
    return $params;
}

function caasify_get_post_array_all()
{
    $params = [];
    foreach ($_POST as $key => $value) {
        $params[$key] = $value;
    }
    return $params;
}

function caasify_has_session($name)
{
    if (array_key_exists($name, $_SESSION)) {
        return true;
    }
    return false;
}

function caasify_get_session($name)
{
    if (caasify_has_session($name)) {
        return $_SESSION[$name];
    }
    return null;
}

function caasify_generate_string($length = 10)
{
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $result = '';
    for ($i=0; $i<$length; $i++) {
        $result .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return $result;
}

// Find the service identity
$serviceId = caasify_get_query('avmServiceId');

// Find action
$action = caasify_get_query('avmAction');

// Find the current logged in client
$client = caasify_get_session('uid');

if ($client) {
    $client = Client::find($client);
    if ($client) {
        $service = $client->services()->find($serviceId);
    }
}

$admin = caasify_get_session('adminid');

if ($admin) {
    $service = Service::find($serviceId);
}

if ($service) {
    $controller = new AVMController($serviceId);
    $controller->handle($action);
} 

function get_config_array_temp(){
    $ModuleConfigArray = [
        'BackendUrl' => null,
        'DefLang' => null,
        'CaasifyCurrency' => null,
        'Commission' => null,
        'CloudTopupLink' => null,
        'AdminClientsSummaryLink' => null,
        'CaasifyMenuTitle' => null,
        'CaasifyMenuPlace' => null,
        'ChargeModule' => null,
        'ViewExchanges' => null,
        'MinimumCharge' => null,
        'MaximumCharge' => null,
        'MinBalanceAllowToCreate' => null,
        'MonthlyCostDecimal' => null,
        'HourlyCostDecimal' => null,
        'BalanceDecimal' => null,
        
        'DevelopeMode' => null,
        'DemoMode' => null,        
        
        'errorMessage' => null,
        
    ];
    return $ModuleConfigArray;
}

function caasify_get_config(){
    try {
        $configTable = Capsule::table('tbladdonmodules')->where('module', 'caasify')->get();
    } catch (\Exception $e) {
        echo "Can not access caasify tables";
        return false;
    }

    $ModuleConfigArray = get_config_array_temp(); 
    if(!empty($configTable)){
        foreach($ModuleConfigArray as $key => $value){
            foreach($configTable as $items){
                if($items->setting == $key){
                    $ModuleConfigArray[$key] = $items->value;
                    if(!isset($items->value) || $items->value === ''){
                        $ModuleConfigArray['errorMessage'] = $key . ' is empty';
                    }
                }
            }
        }
    }

    $Commission = $ModuleConfigArray['Commission'];
    if(isset($Commission)){
        $encodedCommission = base64_encode($Commission);
        $ModuleConfigArray['Commission'] = $encodedCommission;
    }

    $ModuleConfigArray['systemUrl'] = caasify_get_systemUrl();
    return $ModuleConfigArray;
}

function caasify_get_reseller_token(){
    
    try {
        $configTable = Capsule::table('tbladdonmodules')->where('module', 'caasify')->get();
    } catch (\Exception $e) {
        echo "Can not access caasify tables";
        return false;
    }

    if(!empty($configTable)){
        foreach($configTable as $config){
            if($config->setting == 'ResellerToken'){
                $ResellerToken = $config->value;
                break;
            }
        }
    }

    if(empty($ResellerToken)){
        echo "token is empty";
        return false;
    }

    return $ResellerToken;
}

function caasify_get_Demo_Mode(){
    
    try {
        $configTable = Capsule::table('tbladdonmodules')->where('module', 'caasify')->get();
    } catch (\Exception $e) {
        echo "Can not access caasify tables in demo mode";
        return false;
    }

    if(!empty($configTable)){
        foreach($configTable as $config){
            if($config->setting == 'DemoMode'){
                $DemoMode = $config->value;
                break;
            }
        }
    }

    if(empty($DemoMode)){
        echo "DemoMode is empty";
        return false;
    }

    return $DemoMode;
}

function caasify_get_currency_list(){
    $command = 'GetCurrencies';
    $postData = array(
    );
    $results = localAPI($command, $postData);
    
    if(!empty($results['currencies']['currency'])){
        $ResultArray = $results['currencies']['currency'];
    }
    
    $CurrencyArray = [];
    foreach($ResultArray as $arr){
        $CurrencyArray [$arr['code']] = $arr['prefix'];
    }
    return $CurrencyArray;
}

function caasify_get_systemUrl(){
    $command = 'GetConfigurationValue';
    $postData = array(
        'setting' => 'systemUrl',
    );
    $results = localAPI($command, $postData);
    $systemUrl = rtrim($results['value'], '/');
    if(empty($systemUrl)){
        $systemUrl = '/';
    }
    return $systemUrl;
}

function caasify_create_currency_options(){
    $CurrencyArray = caasify_get_currency_list();
    $CurrencyOptions = [];
    if(!empty($CurrencyArray)){
        foreach($CurrencyArray as $key => $vale){
            $CurrencyOptions[$key] = $key;
        }
    }
    return $CurrencyOptions;
}

function caasify_GetDefaulLanguage(){
    $CaasifyConfig = caasify_get_config();
    $allowedLanguages = ['English', 'Farsi', 'Turkish', 'Russian', 'French', 'Deutsch', 'Brizilian', 'Italian'];
    
    // Find DefLang
    if(!empty($CaasifyConfig) && !empty($CaasifyConfig['DefLang']) && in_array($CaasifyConfig['DefLang'], $allowedLanguages)){    
        $DefLang = $CaasifyConfig['DefLang'];
    } else {
        $DefLang = 'English';
    }
    
  

    // Manage Cookies
    if(isset($_COOKIE['temlangcookie'])) {
        $langFromCookies = $_COOKIE['temlangcookie'];
    } else {
        $langFromCookies = $DefLang;
        setcookie('temlangcookie', $DefLang, time() + 365 * 24 * 60 * 60, '/');
    }
    

    // Get templatelang for Client panel
    if(in_array($langFromCookies, $allowedLanguages)){
        $templatelang = $langFromCookies;
    } else {
        $templatelang = $DefLang;
    }
    
    return $templatelang;
}

function caasify_get_user_token_from_db($WhUserId){
    $params = ['WhUserId' => $WhUserId];    
    $user = Capsule::selectOne('SELECT token FROM tblcaasify_user WHERE wh_user_id = :WhUserId', $params);
    return $user->token;
}

function caasify_get_CaasifyUserId_from_WhmUserId($WhUserId){
    $params = ['WhUserId' => $WhUserId];    
    $user = Capsule::selectOne('SELECT caasify_user_id FROM tblcaasify_user WHERE wh_user_id = :WhUserId', $params);
    return $user->caasify_user_id;
}

function caasify_get_userInfo_from_db_if_exist($WhUserId){
    $params = ['WhUserId' => $WhUserId];    
    $user = Capsule::selectOne('SELECT wh_user_id FROM tblcaasify_user WHERE wh_user_id = :WhUserId', $params);
    return $user;
}

// create ordinary user 
function caasify_create_user($BackendUrl, $ResellerToken, $UserFullName, $UserEmail, $password){
    
    $params = [
        'name' => $UserFullName, 'email' => $UserEmail, 'password' => $password
    ];

    $headers = [
        'Accept' =>  'application/json',
        'Authorization' => 'Bearer ' . $ResellerToken
    ];
    
    $address = [
        $BackendUrl, 'api', 'reseller', 'users', 'create'
    ];
    
    return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
}

// Create Reseller user for MyCaasify
function caasify_create_reseller_user($BackendUrl, $ResellerToken, $UserFullName, $UserEmail, $password){
    
    $params = [
        'name' => $UserFullName, 'email' => $UserEmail, 'password' => $password
    ];

    $headers = [
        'Accept' =>  'application/json',
        'Authorization' => 'Bearer ' . $ResellerToken
    ];
    
    $address = [
        $BackendUrl, 'api', 'auth', 'register'
    ];
    
    return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();

}

function caasify_createPassword(){
    $Password = generateRandomPassword();
    return $Password;
}

function generateRandomPassword($length = 12) {
    $possibleChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-=+;:,<.>?';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, strlen($possibleChars) - 1);
        $password .= $possibleChars[$rand];
    }
    return $password;
}

function caasify_get_user_token_from_api($BackendUrl, $UserEmail, $password){
        
    $params = [
        'email' => $UserEmail, 'password' => $password
    ];

    $headers = ['Accept' =>  'application/json'];
    
    $address = [
        $BackendUrl, 'api', 'auth', 'login'
    ];
    
    return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
}

function caasify_get_whmcs_user($WhUserId)
{
    $command = 'GetClientsDetails';
    $postData = array(
        'clientid' => $WhUserId,
        'stats' => true,
    );
    $results = localAPI($command, $postData);

    if($results['result'] == "success"){
        $credit = $results['credit'];
        $currency = $results['currency_code'];
        $userCurrencyId = $results['currency'];
        $response = array(
            'credit' => $credit,
            'currency' => $currency,
            'userCurrencyId' => $userCurrencyId,
        );
        return $response; 
    } else {
        return null;
    } 
}

function caasify_get_Whmcs_Currencies()
{
    $command = 'GetCurrencies';
    $postData = array();
    $results = localAPI($command, $postData);
    return $results; 
}

function caasify_get_token_by_handling($ResellerToken, $BackendUrl, $WhUserId)
{


    $client = Client::find($WhUserId);
    if(empty($client)) {
        echo('can not find the client in token handling');
        return false;
    }

    $token = caasify_get_user_token_from_db($WhUserId);
    
    if(empty($token)) {
        $UserEmail = $client->email;
        $UserFullName = $client->firstname . ' ' . $client->lastname;

        if(empty($UserEmail)) {
            echo('can not UserEmail');
            return false;
        }
        
        if(empty($UserFullName)) {
            echo('can not UserFullName');
            return false;
        }

        
        global $MyCaasifyIsEnabled;
        if(!isset($MyCaasifyIsEnabled) || $MyCaasifyIsEnabled != true){
            $MyCaasifyStatus = 'off';
        } else {
            $MyCaasifyStatus = 'on';
        }

        $password = caasify_createPassword();
        if($MyCaasifyStatus == 'on'){
            if($BackendUrl != null && $ResellerToken != null && $UserFullName != null && $UserEmail != null && $password != null){   
                $CreateResponse = caasify_create_reseller_user($BackendUrl, $ResellerToken, $UserFullName, $UserEmail, $password);
            } else {
                echo('something is missing');
                return false;
            }
        } else {
            if($BackendUrl != null && $ResellerToken != null && $UserFullName != null && $UserEmail != null && $password != null){   
                $CreateResponse = caasify_create_user($BackendUrl, $ResellerToken, $UserFullName, $UserEmail, $password);
            } else {
                echo('something is missing');
                return false;
            }
        }

        if(empty($CreateResponse)) {
            echo('create request did not work in token handling');
            return false;
        }

        $message = property_exists($CreateResponse, 'message');
        if (!empty($message)) {     
            echo($CreateResponse->message);
            return false;
        }  
            
        $wh_user_id = caasify_get_userInfo_from_db_if_exist($WhUserId);
        if(empty($wh_user_id)){
            $params = [
                'wh_user_id' => $WhUserId, 
                'caasify_user_id' => null, 
                'token' => null, 
                'email' => $UserEmail, 
                'password' => $password
            ];

            try {
                Capsule::table('tblcaasify_user')->insert($params);
            } catch (\Exception $e) {
                echo 'Error inserting user info into data base in handling  <br>';
                return false;
            }
        } 

        $token = $CreateResponse->token;
        if (empty($token)) {
            $requestTokenResponse = caasify_get_user_token_from_api($BackendUrl, $UserEmail, $password);
            if(empty($requestTokenResponse)) {
                echo 'can not get the token while login in token handling  <br>' ;
                return false;
            }

            $message = property_exists($requestTokenResponse, 'message');
            if(!empty($message)) {  
                echo($requestTokenResponse->message);
                return false;
            }

            $token = $requestTokenResponse->data->token;
            if(empty($token)){
                echo('token received is empty');
                return false;
            }
        }

        $CaasifyUserId = $CreateResponse->data->id;
        if(empty($CaasifyUserId)){
            echo 'No id in regiteration received is empty <br>';
            return false;
        }

        // Save token in WHMCS
        $params = [
            'wh_user_id' => $WhUserId, 
            'caasify_user_id' => $CaasifyUserId, 
            'token' => $token, 
            'email' => $UserEmail, 
            'password' => $password
        ];

        try {
            // Check if a record with the given wh_user_id exists
            $existingRecord = Capsule::table('tblcaasify_user')
                ->where('wh_user_id', $WhUserId)
                ->first();
    
            if ($existingRecord) {
                // If record exists, update it
                Capsule::table('tblcaasify_user')
                    ->where('wh_user_id', $WhUserId)
                    ->update($params);
            } else {
                // If no record exists, insert a new one
                Capsule::table('tblcaasify_user')
                    ->insert($params);
            }
        } catch (\Exception $e) {
            echo 'Error inserting data into data base in handling <br>';
            return false; // Indicate failure
        }
    }

    return $token;
}

function caasify_charge_user_from_invoice_hook($ResellerToken, $BackendUrl, $CaasifyUserId, $chargeamount, $invoiceid){
    
    $params = [
        'amount' => $chargeamount,
        'type' => 'balance',
        'invoiceid' => $invoiceid,
        'status' => 'paid'
    ];

    $headers = [
        'Accept' =>  'application/json',
        'Authorization' => 'Bearer ' . $ResellerToken
    ];
    
    $address = [
        $BackendUrl, 'api', 'users', $CaasifyUserId, 'transactions', 'increase'
    ];
    
    return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();

}


function Caasify_Set_Log($message = 'Unknown error'){
    $uid = caasify_get_session('uid');
    $command = 'LogActivity';
    $postData = array(
        'action' => 'Caasify Charging from Invoice',
        'clientid' => $uid,
        'description' => $message,
    );
    $results = localAPI($command, $postData);
    return true;
}