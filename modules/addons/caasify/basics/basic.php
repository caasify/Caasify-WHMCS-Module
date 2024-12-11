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
        'ViewExchanges' => null,
        'MinimumCharge' => null,
        'MaximumCharge' => null,
        'MinBalanceAllowToCreate' => null,
        'MonthlyCostDecimal' => null,
        'HourlyCostDecimal' => null,
        'BalanceDecimal' => null,
        
        'VPNSectionEnabled' => null,
        'VPNSectionMenuTitle' => null,

        'VpsPricingEnabled' => null,
        'VpsPricingMenuTitle' => null,
        'CaasifyCurrencyForVPSPricing' => null,
        
        'resellerMode' => null,
        'DevelopeMode' => null,
        'DemoMode' => null,        
        
        'errorMessage' => null,
        
    ];
    return $ModuleConfigArray;
}

function caasify_get_config_encoded(){
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

function caasify_get_config_decoded(){
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
    $CaasifyConfig = caasify_get_config_decoded();
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

function caasify_get_whuser_from_id($WhUserId){
    $userDetails = Capsule::table('tblclients')
    ->where('id', $WhUserId)
    ->first();
    
    return $userDetails;
}

function caasify_get_invoice_info_from_invoiceid($invoiceId){
    
    $command = 'GetInvoice';
    $postData = array(
        'invoiceid' => $invoiceId,
    );

    $results = localAPI($command, $postData);
    return $results;
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
        $countrycode = $results['countrycode'];
        $response = array(
            'credit' => $credit,
            'currency' => $currency,
            'userCurrencyId' => $userCurrencyId,
            'countrycode' => $countrycode,
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
        'reference' => $invoiceid,
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

function caasify_charge_Reseller_from_invoice_hook($ResellerToken, $BackendUrl, $CaasifyUserId, $chargeamount, $invoiceid){
    
    $params = [
        'amount' => $chargeamount,
        'reference' => $invoiceid,
    ];

    $headers = [
        'Accept' =>  'application/json',
        'Authorization' => 'Bearer ' . $ResellerToken
    ];
    
    $address = [
        $BackendUrl, 'api', 'backend', 'users', $CaasifyUserId, 'transactions', 'increase'
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

function cassify_create_invoice_table_database(){
    $hasTable = Capsule::schema()->hasTable('tblcaasify_invoices');

    if($hasTable) {
        try {
            if (!Capsule::schema()->hasColumn('tblcaasify_invoices', 'real_charge_amount')) {
                Capsule::schema()->table('tblcaasify_invoices', function ($table) {
                    $table->decimal('real_charge_amount', 30, 2)->nullable()->after('chargeamount');
                });
            }
            if (!Capsule::schema()->hasColumn('tblcaasify_invoices', 'commission')) {
                Capsule::schema()->table('tblcaasify_invoices', function ($table) {
                    $table->decimal('commission', 30, 2)->nullable()->after('chargeamount');
                });
            }
        } catch (PDOException $e) {
            return false;
        }
    } else {
        try {
            Capsule::schema()->create('tblcaasify_invoices', function ($table) {
                $table->increments('id');
                $table->unsignedInteger('whuserid')->nullable();
                $table->unsignedBigInteger('caasifyid')->nullable();
                $table->decimal('ratio', 30, 10)->nullable();
                $table->unsignedInteger('invoiceid')->nullable();
                $table->decimal('chargeamount', 30, 2)->nullable();
                $table->decimal('real_charge_amount', 30, 2)->nullable();
                $table->decimal('commission', 30, 2)->nullable();
                $table->unsignedInteger('transactionid')->nullable();
                $table->timestamps();
            });
        } catch (PDOException $e) {
            return false;
        }
    }

    return true;
}

function cassify_getinfo_invoice_table($invoiceid){
    $hasTable = Capsule::schema()->hasTable('tblcaasify_invoices');

    if(!empty($hasTable)) {
        try {
            $invoiceData = Capsule::table('tblcaasify_invoices')->where('invoiceid', $invoiceid)->first();
            return ($invoiceData);
        } catch (PDOException $e) {
            return false;
        }
    }

    return false;
}

function cassify_get_all_invoice_table(){
    $hasTable = Capsule::schema()->hasTable('tblcaasify_invoices');

    if(!empty($hasTable)) {
        try {
            // Fetch the latest 30 records, ordered by 'id' or 'created_at'
            $invoices = Capsule::table('tblcaasify_invoices')
                ->orderBy('id', 'desc') // Adjust the column name if necessary
                ->limit(100)
                ->get();
            return ($invoices);
        } catch (PDOException $e) {
            return false;
        }
    }

    return false;
}

function cassify_update_caasify_invoice_table($invoiceid, $TransactionId, $ChargeAmountInCloudCurr, $Commission){
    $hasTable = Capsule::schema()->hasTable('tblcaasify_invoices');
    
    if(!empty($hasTable)) {
        try {
            $updateData = Capsule::table('tblcaasify_invoices')
            ->where('invoiceid', $invoiceid)
            ->update([
                'transactionid' => $TransactionId, 
                'real_charge_amount' => $ChargeAmountInCloudCurr,
                'commission' => $Commission,
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    if(isset($updateData)){
        return true;
    } else {
        return false;
    }
}


function caasify_calculate_ratio_for_vpspricing(){
    
    // find commission
    $configs = caasify_get_config_decoded();
    $Commission = 0;
    if(isset($configs['Commission'])){
        $Commission = $configs['Commission'];
    } 
    
    // find default currency for vpss page
    if(isset($configs['CaasifyCurrencyForVPSPricing'])){
        $CaasifyCurrencyForVPSPricing = $configs['CaasifyCurrencyForVPSPricing'];
    } else {
        $CaasifyCurrencyForVPSPricing = 'EUR';
    }

    // find ratio to change price
    $euroRatio = 1;
    $targetRatio = 1;
    $finalRatio = 1;
    $currenciesList = caasify_get_Whmcs_Currencies();
    if(isset($currenciesList['currencies']['currency'])){
        $currencies = $currenciesList['currencies']['currency'];
    }

    if(is_array($currencies)){
        foreach($currencies as $currency){
            if($currency['code'] == 'EUR'){
                $euroRatio = $currency['rate'];
            }
            if($currency['code'] == $CaasifyCurrencyForVPSPricing){
                $targetRatio = $currency['rate'];
                $targetCurrencySuffix = $currency['suffix'];
            }
        }
    }

    if(isset($euroRatio) && isset($targetRatio) && isset($Commission)){
        $finalRatio = ($targetRatio / $euroRatio) * (100 + $Commission) / 100;
    }

    $response = [
        'ratio' => $finalRatio,
        'currency' => $targetCurrencySuffix,
    ];

    return $response;
}

/**
 * Checks if a user is new.
 *
 * A new user is defined as someone who has not made any payments yet.
 *
 * @param int $whUserId     The user ID in the WH system.
 *
 * @return bool             Returns true if the user is new, otherwise false.
 */
function caasify_is_user_new($whUserid)
{
    $query = Capsule::table("tblcaasify_invoices")->where("whuserid", $whUserid)->count();
    if($query > 0)
        return false;
    else
        return true;
}


function cassify_get_all_promotion_table(){
    $hasTable = Capsule::schema()->hasTable('tblcaasify_promotions');

    if(!empty($hasTable)) {
        try {
            // Fetch the latest 30 records, ordered by 'id' or 'created_at'
            $invoices = Capsule::table('tblcaasify_promotions')
                ->orderBy('id', 'desc') // Adjust the column name if necessary
                ->limit(100)
                ->get();
            return ($invoices);
        } catch (PDOException $e) {
            return false;
        }
    }

    return false;
}

function cassify_get_all_wh_users(){
    $hasTable = Capsule::schema()->hasTable('tblusers');

    if(!empty($hasTable)) {
        try {
            // Fetch the latest 30 records, ordered by 'id' or 'created_at'
            $invoices = Capsule::table('tblusers')
                ->get();
            return ($invoices);
        } catch (PDOException $e) {
            return false;
        }
    }

    return false;
}


/**
 * Validates a promotion code and calculates the final price if valid.
 *
 * This function checks if the provided promotion code is still active,
 * has not expired, meets usage limits, and satisfies the defined conditions.
 * If the code is valid, it returns the increased final price for recharging.
 *
 * @param string $code      The promotion code to validate.
 * @param float  $price     The initial price before applying the promotion.
 * @param int    $WhUserId  The user ID from the WH table, used to track individual usage.
 *
 * @return array            [bool isValid, string message, float final_price]
 *                           - isValid: True if promotion is applicable, otherwise false.
 *                           - message: Explanation of validation result.
 *                           - final_price: The adjusted price after applying the promotion,
 *                               or the original price if the promotion is invalid.
 */
function caasify_promotion_validation($code , $price , $WhUserId){
    $promotion = Capsule::table('tblcaasify_promotions')->where('code' , $code );

    if($promotion->exists()){

        $promotion = $promotion->first();

        $now = ( new DateTime("now") ) -> format("Y-m-d");

        //check if promotion is active
        if($promotion->status == 0){
            return [ false , "1001 : This promotion code has expired and is no longer available for use." , $price];

        }

        // Check if the promotion falls within the acceptable usage date range (start_date to expiration_date).
        if( $promotion->start_date <= $now && $promotion->expiration_date >= $now ){

            if($promotion->max_use != 0 and $promotion->uses >= $promotion->max_use)
            {
                return [ false , "1003 : This promotion code has reached its usage limit and can no longer be used." , $price];
            }
            else {
                // Check if the promotion meets the price limitations (e.g., minimum or maximum price).
                if($promotion->conditions != null){

                    $conditions = unserialize($promotion->conditions);

                    if( isset($conditions["min_amount"]) and $conditions["min_amount"] != 0 ){
                        if($price < $conditions["min_amount"]){
                            return [ false , "1004 : The purchase amount does not meet the minimum required for this promotion code." , $price];
                        }
                    }

                    if( isset($conditions["max_amount"]) and $conditions["max_amount"] != 0 ){
                        if($price > $conditions["max_amount"]){
                            return [ false , "1005 : The purchase amount exceeds the maximum allowed for this promotion code." , $price];
                        }
                    }
                }

                if($promotion->recurring_no > 0){
                    $repetitionCount = Capsule::table("tblcaasify_promotions_used") -> where( 'promotion_id' , $promotion->id) -> where('user_id' , $WhUserId ) ->count();

                    if($promotion->recurring_no <= $repetitionCount){
                        return [ false , "1006 : You have already used this promotion code the maximum allowed number of times." , $price];

                    }

                }

                // Proceed to the next step, as all base requirements have been met. Now, check if the promotion code is valid for the user!
                if($promotion->user_type == "all_users")
                {
                    return [ true , "Successful" , caasify_calculate_promotion_final_price($price , $promotion->type , $promotion->value) ];
                }
                else if($promotion->user_type == "new_users"){
                    if(caasify_is_user_new($WhUserId) == true)
                    {
                        return [ true , "Successful" , caasify_calculate_promotion_final_price($price , $promotion->type , $promotion->value) ];
                    }
                    else
                    {
                        return [ false , "1007 : This promotion code is only available for new users." , $price];
                    }
                }
                else if($promotion->user_type == "specific_users"){

                    if($promotion->user_list != null){

                        $user_list = unserialize($promotion->user_list);

                        if(in_array($WhUserId, $user_list)){
                             return [ true , "Successful" , caasify_calculate_promotion_final_price($price , $promotion->type , $promotion->value) ];
                        }
                        else{
                            return [ false , "1008 : This promotion code is not valid." , $price];
                        }
                    }
                    else{
                        return [ false , "1009 : This promotion code is not valid." , $price];
                    }
                }
            }
        }
        else {
            return [ false , "10010 : This promotion code has expired and is no longer available for use." , $price];
        }
    }
    else {
        return [ false , "10011 :The promotion code entered does not exist. Please check and try again." , $price];
    }

}

/**
 * Applies a promotion code to calculate the final price for an account recharge.
 *
 * This function first validates the promotion code by calling the `caasify_promotion_validation` function.
 * If the code is valid, it records the usage in the database, updates the promotion's usage count,
 * and returns the adjusted price for the recharge. If invalid, it returns the original price.
 *
 * @param string $code       The promotion code to validate and apply.
 * @param float  $price      The initial price before applying the promotion.
 * @param int    $WhUserId   The user ID from the WH table, used to track individual usage.
 * @param int    $invoice_id The invoice ID associated with this promotion application.
 *
 * @return array             [bool isOk, float final_price]
 *                            - isOk: True if promotion is applicable, otherwise false.
 *                            - final_price: The adjusted price after applying the promotion,
 *                              or the original price if the promotion is invalid.
 */
function caasify_use_promotion($code , $price , $WhUserId , $invoice_id)
{
    $validation = caasify_promotion_validation($code , $price , $WhUserId);

    if($validation[0] === true)
    {
        $promotion = Capsule::table('tblcaasify_promotions')->where('code' , $code );

        Capsule::table("tblcaasify_promotions_used")->insert([
            'invoice_id' => $invoice_id,
            'user_id' => $WhUserId,
            'promotion_id' => $promotion->first()->id
        ]);

        $promotion->update([
            "uses" => $promotion->uses + 1
        ]);

        return [true , $validation[2]];
    }
    else {
        return [false , $price];
    }
}
/**
 * Calculates the final price after applying a promotion.
 *
 * This function applies a fixed or percentage-based promotion to an initial price and
 * returns the adjusted price rounded to two decimal places.
 *
 * @param float  $price     The initial price before applying the promotion.
 * @param string $type      The type of promotion ("fixed" or "percent").
 * @param float  $value     The promotion amount. If type is "fixed", this is added directly;
 *                          if "percent", this is treated as a percentage.
 *
 * @return float            The adjusted price after applying the promotion, rounded to two decimal places.
 */
function caasify_calculate_promotion_final_price($price, $type, $value){
    if ($type == "fixed") {
        return number_format($price + $value, 2, '.', '');
    }

    $increase = $price * $value / 100;
    return number_format($price + $increase, 2, '.', '');
}