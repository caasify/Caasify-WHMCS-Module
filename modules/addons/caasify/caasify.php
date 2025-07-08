<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use PG\Request\Request;
use WHMCS\User\Client;

$path = dirname(__FILE__);
require_once $path . '/ClientCaasifyController.php';
require_once $path . '/basics.php';

// Create Table user and order
function caasify_activate(){

    $hasTable = Capsule::schema()->hasTable('tblcaasify_user');
    if (empty($hasTable)) {
        Capsule::schema()->create('tblcaasify_user', function ($table) {
            $table->increments('id');
            $table->string('wh_user_id')->nullable();
            $table->string('caasify_user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('token')->nullable();
            $table->string('password')->nullable();
        });
    }

    /** PROMOTIONS ! **/
    $hasPromotionTable = Capsule::schema()->hasTable('tblcaasify_promotions');
    if (empty($hasPromotionTable)) {

        Capsule::schema()->create('tblcaasify_promotions' , function ($table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type' , ['percent' , 'fixed'])->default('percent');
            $table->integer('value');
            $table->date('start_date');
            $table->date('expiration_date');
            $table->integer('max_use')-> default(0);
            $table->integer('uses') -> default(0);
            $table->integer('recurring_no') -> default(1);
            $table->enum('user_type' , ["new_users" , "all_users" , "specific_users"]) -> default("all_users");
            $table->longText('user_list') -> nullable();
            $table->text('conditions') -> nullable();
            $table->boolean('status') -> default(true);
        });
    }

    $hasPromotionUsedTable = Capsule::schema()->hasTable('tblcaasify_promotions_used');
    if (empty($hasPromotionUsedTable)) {

        Capsule::schema()->create('tblcaasify_promotions_used' , function ($table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('promotion_id');
            $table->integer('user_id');
        });
    }

    // Change currency ratio decimals
    try {
        $pdo = Capsule::connection()->getPdo();
        $pdo->exec('ALTER TABLE tblcurrencies MODIFY rate decimal(30, 10)');
    } catch (PDOException $e) {

    }

    // create invoice data base in admin panel
    $invoiceDatabaseStatus = cassify_create_invoice_table_database();
    if(isset($invoiceDatabaseStatus) && $invoiceDatabaseStatus != true){
        echo('<h4 style="color:red;">can not fine invoice table, call your admin</h4>');
        return false;
    }

}

// Module Config
function caasify_config(){

    $SystemUrl = caasify_get_systemUrl();

    $fields = caasify_get_array('fields', $_POST);

    if ($fields) {

        $caasify = caasify_get_array('caasify', $fields);

        if ($caasify) {

            $caasifyUrl = caasify_get_array('BackendUrl', $caasify);
            $caasifyToken = caasify_get_array('ResellerToken', $caasify);

            $caasifySubject = caasify_get_array('EmailSubject', $caasify);
            $caasifyContent = caasify_get_array('EmailContent', $caasify);
            $caasifyFromName = caasify_get_array('EmailFromName', $caasify);

            if ($caasifyUrl) {

                $address = [
                    $caasifyUrl, 'api', 'reseller', 'templates', 'save'
                ];

                $headers = [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$caasifyToken}"
                ];

                $params = [
                    'subject' => $caasifySubject, 
                    'content' => $caasifyContent, 
                    'from_name' => $caasifyFromName
                ];

                Request::instance()
                    ->setAddress($address)
                    ->setHeaders($headers)
                    ->setParams($params)->getResponse();
            }
        }
    }
    
    // Variables
    $CurrencyOptions = caasify_create_currency_options();
    $LanguageOptions = array (
        'English' => 'English',
        'Farsi' => 'فارسی',
        'Turkish' => 'Türkçe',
        'French' => 'Français',
        'Deutsch' => 'Deutsch',
        'Russian' => 'Pусский',
        'Brizilian' => 'Brizilian',
        'Italian' => 'Italian',
    );

    $YesNoOptions = array (
        'on' => 'on',
        'off' => 'off',
    );

    $DecimalOptions = array (
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    );

    $MenuPlaceOptions = array (
        'MainMenu' => 'Main Menu',
        'InsideServices' => 'Inside Services',
        'Hidden' => 'Hidden'
    );


    // Labels
    $BackendUrlLabel = "Default is (https://api.caasify.com)";
    $ResellerTokenLabel = 'Insert your Reseller Token here, get it by registering on my.caasify.com';
    $DefLangLabel = 'This is Defaul Language for clients panel on first visit, they can chagne it by their preference';
    $CaasifyCurrencyLabel = 'It must be <strong>EURO</strong> (Caasify Currency). If you dont have EURO, you must create one in System Setting/currency and then select it here';
    $CommissionCurrencyLabel = '<strong> % Percent </strong>, this is the comission which will add to the product prices, default is 10%';

    $ViewExchangesLabel = 'Switch on if wish to see exchange in both Caasify and user profile currency';
    $CloudTopupLinkLabel = 'Insert relative TopUp Link, as an Example <strong>"/clientarea.php?action=addfunds"</strong>';
    $AdminClientsSummaryLinkLabel = 'Insert admin panel URL for the Clients Summary Page, e.g <strong>(' . $SystemUrl . '/admin/clientssummary.php)</strong>';
    $CaasifyMenuTitleLabel = 'Insert label to show on Menu, default is <strong>"Marketplace"</strong>';
    $CaasifyMenuPlaceLabel = 'Select where Menu Title will show, default is <strong>"Main Menu"</strong>';

    // Configs Label
    $MinimumChargeLabel = 'in EURO , insert MIN amount users are allowed to charge their Balance';
    $MaxChargeLabel = 'in EURO , insert MAX amount users are allowed to charge their Balance';
    $MinimumBalanceLabel = 'in EURO , insert lowest user Balance allowed to create an order';

    $MonthlyCostDecimalLabel = 'default decimal for Monthly cost of services';
    $HourlyCostDecimalLabel = 'default decimal for Hourly cost of services';
    $BalanceDecimalLabel = 'default decimal for users Balance and Credit';

    $resellerModeLabel = '<strong>Do Not Turn this ON, </strong> Switch on ONLY if you wish to give your reseller their token';
    $DevelopeModeLabel = '<strong>Do Not Turn this ON, </strong> Switch on ONLY for debuging, after debuging turn it off';
    $DemoModeLabel = '<strong>Do Not Turn this ON, </strong> Switch on ONLY for testing, but for normal usage turn it off';

    // VPS Pricing
    $VpsPricingEnabledLabel = 'Switch on if you wish to show VPS Pricing page without log in on URL: domain/vpspricing.php';
    $CaasifyCurrencyForVPSPricing = 'VPS pricing page will be shown publicly with this currency';
    $VpsPricingMenuTitleLabel = 'Insert MENU label for VPS Pricing page, default is <strong>"VPS Pricing"</strong>';

    $VPNSectionEnabledLabel = 'Switch on if you wish to show VPN page and sell products';
    $VPNSectionMenuTitleLabel = 'Insert MENU label for VPN section page, default is <strong>"VPN"</strong>';


    $configarray = array(
        "name" => "Caasify",
        "description" => "This addon utility allows you to easily connect to Caasify Marketpalce to sell almost everything",
        "version" => "2.1.2",
        "author" => "Caasify",
        "fields" => array(
            "BackendUrl" => array ("FriendlyName" => "Backend URL", "Type" => "dropdown", "Options" => 'https://cas.payacloud.online', "Description" => $BackendUrlLabel, "Default" => 'https://api.caasify.com'),
            "ResellerToken" => array ("FriendlyName" => "Reseller Token", "Type" => "text", "Size" => "31", "Description" => $ResellerTokenLabel, "Default" => ""),
            "DefLang" => array ("FriendlyName" => "Panel Language", "Type" => "dropdown", "Options" => $LanguageOptions, "Description" => $DefLangLabel, "Default" => "English"),
            "CaasifyCurrency" => array ("FriendlyName" => "<strong>Caasify Currency</strong>", "Type" => "dropdown", "Options" => $CurrencyOptions, "Description" => $CaasifyCurrencyLabel, "Default" => 'USD'),

            "Commission" => array ("FriendlyName" => "<strong>Commission</strong>", "Type" => "text", "Description" => $CommissionCurrencyLabel, "Default" => '10'),
            "CloudTopupLink" => array ("FriendlyName" => "Topup Link", "Type" => "text", "Size" => "31", "Description" => $CloudTopupLinkLabel, "Default" => "/clientarea.php?action=addfunds"),
            "AdminClientsSummaryLink" => array ("FriendlyName" => "Admin Panel URL", "Type" => "text", "Size" => "31", "Description" => $AdminClientsSummaryLinkLabel, "Default" => $SystemUrl . '/admin/clientssummary.php'),
            "CaasifyMenuTitle" => array ("FriendlyName" => "Menu Title", "Type" => "text", "Size" => "31", "Description" => $CaasifyMenuTitleLabel, "Default" => "Marketplace"),
            "CaasifyMenuPlace" => array ("FriendlyName" => "Menu Place", "Type" => "dropdown", "Options" => $MenuPlaceOptions, "Description" => $CaasifyMenuPlaceLabel, "Default" => 'MainMenu'),

            "ViewExchanges" => array ("FriendlyName" => "View Exchange", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $ViewExchangesLabel, "Default" => 'off'),
            "MinimumCharge" => array ("FriendlyName" => "Minimum TopUp", "Type" => "text", "Size" => "10", "Description" => $MinimumChargeLabel, "Default" => 1),
            "MaximumCharge" => array ("FriendlyName" => "Maximum TopUp", "Type" => "text", "Size" => "10", "Description" => $MaxChargeLabel, "Default" => 500),
            "MinBalanceAllowToCreate" => array ("FriendlyName" => "Minimum Balance to order", "Type" => "text", "Size" => "10", "Description" => $MinimumBalanceLabel, "Default" => 1),
            "MonthlyCostDecimal" => array ("FriendlyName" => "Monthly Cost Decimal", "Type" => "dropdown", "Options" => $DecimalOptions, "Description" => $MonthlyCostDecimalLabel, "Default" => '2'),
            "HourlyCostDecimal" => array ("FriendlyName" => "Hourly Cost Decimal", "Type" => "dropdown", "Options" => $DecimalOptions, "Description" => $HourlyCostDecimalLabel, "Default" => '2'),
            "BalanceDecimal" => array ("FriendlyName" => "Balance Decimal", "Type" => "dropdown", "Options" => $DecimalOptions, "Description" => $BalanceDecimalLabel, "Default" => '2'),
            "resellerMode" => array ("FriendlyName" => "<strong>Reseller Mode</strong>", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $resellerModeLabel, "Default" => 'off'),
            "DevelopeMode" => array ("FriendlyName" => "<strong>Develope Mode</strong>", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $DevelopeModeLabel, "Default" => 'off'),
            "DemoMode" => array ("FriendlyName" => "<strong>DEMO Mode</strong>", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $DemoModeLabel, "Default" => 'off'),

            "VpsPricingEnabled" => array ("FriendlyName" => "VPS Pricing Enable", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $VpsPricingEnabledLabel, "Default" => 'on'),
            "CaasifyCurrencyForVPSPricing" => array ("FriendlyName" => "VPS pricing currency", "Type" => "dropdown", "Options" => $CurrencyOptions, "Description" => $CaasifyCurrencyForVPSPricing, "Default" => 'EURO'),
            "VpsPricingMenuTitle" => array ("FriendlyName" => "VPS Pricing Menu Title", "Type" => "text", "Size" => "31", "Description" => $VpsPricingMenuTitleLabel, "Default" => "VPS Pricing"),

            "VPNSectionEnabled" => array ("FriendlyName" => "VPN selling Enable", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $VPNSectionEnabledLabel, "Default" => 'on'),
            "VPNSectionMenuTitle" => array ("FriendlyName" => "VPN Menu Title", "Type" => "text", "Size" => "31", "Description" => $VPNSectionMenuTitleLabel, "Default" => "VPN"),

            "EmailSubject" => array("FriendlyName" => "Email Subject", "Type" => "text"),
            "EmailContent" => array("FriendlyName" => "Email Content", "Type" => "textarea"),
            "EmailFromName" => array("FriendlyName" => "Email From Name", "Type" => "text")
        ));

    return $configarray;
}

function caasify_output($vars) {

    // Fetch WHMCS configurations
    $config = caasify_get_config_decoded();

    // Fetch system URL 
    $systemUrl = caasify_get_array('systemUrl', $config);

    if (!$systemUrl) {
        exit('Could not find system URL.');
    }

    require('admin/iframe.php');
}

// Create Client Panel Controller
function caasify_clientarea($vars){
    if (!isset($_SESSION['uid'])) {
        header('Location: /index.php?rp=/login');
        exit();
    }

    $WhUserId = caasify_get_session('uid');
    if(empty($WhUserId)){
        echo 'can not find WhUserId to construct controller <br>';
        return false;
    }

    $ResellerToken = caasify_get_reseller_token();
    if(empty($ResellerToken)){
        echo 'can not find ResellerToken to construct controller <br>';
        return false;
    }

    $configs = caasify_get_config_decoded();
    $BackendUrl = $configs['BackendUrl'];
    if(empty($BackendUrl)){
        echo 'can not find BackendUrl to construct controller <br>';
        return false;
    }

    $DevelopeMode = $config['DevelopeMode'];
    if(empty($DevelopeMode)){
        $DevelopeMode = 'off';
    }

    $VpsPricingEnabled = $config['VpsPricingEnabled'];
    if(empty($VpsPricingEnabled)){
        $VpsPricingEnabled = 'on';
    }


    $VPNSectionMenuTitle = $config['VPNSectionMenuTitle'];
    if(empty($VPNSectionMenuTitle)){
        $VPNSectionMenuTitle = 'VPN';
    }

    $VPNSectionEnabled = $config['VPNSectionEnabled'];
    if(empty($VPNSectionEnabled)){
        $VPNSectionEnabled = 'on';
    }

    $resellerMode = $config['resellerMode'];
    if(empty($resellerMode)){
        $resellerMode = 'off';
    }

    $DemoMode = caasify_get_Demo_Mode();
    if(empty($DemoMode) || $DemoMode != 'on'){
        $DemoMode = 'off';
    }

    if(!empty($ResellerToken) && !empty($BackendUrl) && !empty($WhUserId)){
        $UserToken = caasify_get_token_by_handling($ResellerToken, $BackendUrl, $WhUserId);
    }

    if(empty($UserToken)){
        echo "can not find user token in client area <br>";
        return false;
    }


    $CaasifyUserId = caasify_get_CaasifyUserId_from_WhmUserId($WhUserId);
    if(empty($CaasifyUserId)){
        echo "can not find CaasifyUserId in client area <br>";
        return false;
    }

    $action = caasify_get_query('action');

    if(!empty($action) && !empty($BackendUrl) && !empty($ResellerToken) && !empty($UserToken) && !empty($CaasifyUserId) && !empty($WhUserId) && !empty($DemoMode)){
        try {
            $controller = new ClientCaasifyController($BackendUrl, $ResellerToken, $UserToken, $CaasifyUserId, $WhUserId, $DemoMode);
            return $controller->handle($action);
        } catch (Exception $e) {
            if($DevelopeMode == 'on'){
                echo("Error run AdminController in admin hook: " . $e);
                return false;
            } else {
                echo('Error while run admin controler');
                return false;
            }
        }
    }
}
