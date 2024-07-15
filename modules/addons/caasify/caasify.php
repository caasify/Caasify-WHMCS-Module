<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
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

    // Change currency ratio decimals
    try {
        $pdo = Capsule::connection()->getPdo();
        $pdo->exec('ALTER TABLE tblcurrencies MODIFY rate decimal(30, 10)');
    } catch (PDOException $e) {

    }
    
}

// Module Config
function caasify_config(){

    $SystemUrl = caasify_get_systemUrl();
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
        'InsideServices' => 'Inside Services'
    );

    
    // Labels
    $BackendUrlLabel = "Default is (https://api.caasify.com)";
    $ResellerTokenLabel = 'Insert your Reseller Token here, get it by registering on my.caasify.com';
    $DefLangLabel = 'This is Defaul Language for clients panel on first visit, they can chagne it by their preference';
    $CaasifyCurrencyLabel = 'It must be <strong>EURO</strong> (Caasify Currency). If you dont have EURO, you must create one in System Setting/currency and then select it here';
    $CommissionCurrencyLabel = '<strong> % Percent </strong>, this is the comission which will add to the product prices, default is 10%';
    
    $ChargeModuleLabel = 'Switch on if wish to use Charging Module that allows users to transfer their Credit too their Caasify Balance';
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

    $DevelopeModeLabel = '<strong>Do Not Turn this ON, </strong> Switch on Developing Mode only for debuging, after debuging turn it off';
    $DemoModeLabel = '<strong>Do Not Turn this ON, </strong> Switch on DEMO Mode only for user TEST, so for normal usage turn it off';

    $configarray = array(
        "name" => "Caasify",
        "description" => "This addon utility allows you to easily connect to Caasify Marketpalce to sell almost everything",
        "version" => "1.1.1",
        "author" => "Caasify",
        "fields" => array(
            "BackendUrl" => array ("FriendlyName" => "Backend URL", "Type" => "dropdown", "Options" => 'https://api.caasify.com', "Description" => $BackendUrlLabel, "Default" => 'https://api.caasify.com'),
            "ResellerToken" => array ("FriendlyName" => "Reseller Token", "Type" => "text", "Size" => "31", "Description" => $ResellerTokenLabel, "Default" => ""),
            "DefLang" => array ("FriendlyName" => "Panel Language", "Type" => "dropdown", "Options" => $LanguageOptions, "Description" => $DefLangLabel, "Default" => "English"),
            "CaasifyCurrency" => array ("FriendlyName" => "<strong>Caasify Currency</strong>", "Type" => "dropdown", "Options" => $CurrencyOptions, "Description" => $CaasifyCurrencyLabel, "Default" => 'USD'),
            "Commission" => array ("FriendlyName" => "<strong>Commission</strong>", "Type" => "text", "Description" => $CommissionCurrencyLabel, "Default" => '10'),
            "CloudTopupLink" => array ("FriendlyName" => "Topup Link", "Type" => "text", "Size" => "31", "Description" => $CloudTopupLinkLabel, "Default" => "/clientarea.php?action=addfunds"),
            "AdminClientsSummaryLink" => array ("FriendlyName" => "Admin Panel URL", "Type" => "text", "Size" => "31", "Description" => $AdminClientsSummaryLinkLabel, "Default" => $SystemUrl . '/admin/clientssummary.php'),
            "CaasifyMenuTitle" => array ("FriendlyName" => "Menu Title", "Type" => "text", "Size" => "31", "Description" => $CaasifyMenuTitleLabel, "Default" => "Marketplace"),
            "CaasifyMenuPlace" => array ("FriendlyName" => "Menu Place", "Type" => "dropdown", "Options" => $MenuPlaceOptions, "Description" => $CaasifyMenuPlaceLabel, "Default" => 'MainMenu'),

            "ChargeModule" => array ("FriendlyName" => "Chargeing Module", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $ChargeModuleLabel, "Default" => 'on'),
            "ViewExchanges" => array ("FriendlyName" => "View Exchange", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $ViewExchangesLabel, "Default" => 'off'),
            "MinimumCharge" => array ("FriendlyName" => "Minimum TopUp", "Type" => "text", "Size" => "10", "Description" => $MinimumChargeLabel, "Default" => 1),
            "MaximumCharge" => array ("FriendlyName" => "Maximum TopUp", "Type" => "text", "Size" => "10", "Description" => $MaxChargeLabel, "Default" => 500),
            "MinBalanceAllowToCreate" => array ("FriendlyName" => "Minimum Balance to order", "Type" => "text", "Size" => "10", "Description" => $MinimumBalanceLabel, "Default" => 1),
            "MonthlyCostDecimal" => array ("FriendlyName" => "Monthly Cost Decimal", "Type" => "dropdown", "Options" => $DecimalOptions, "Description" => $MonthlyCostDecimalLabel, "Default" => '2'),
            "HourlyCostDecimal" => array ("FriendlyName" => "Hourly Cost Decimal", "Type" => "dropdown", "Options" => $DecimalOptions, "Description" => $HourlyCostDecimalLabel, "Default" => '2'),
            "BalanceDecimal" => array ("FriendlyName" => "Balance Decimal", "Type" => "dropdown", "Options" => $DecimalOptions, "Description" => $BalanceDecimalLabel, "Default" => '2'),
            "DevelopeMode" => array ("FriendlyName" => "<strong>Develope Mode</strong>", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $DevelopeModeLabel, "Default" => 'off'),
            "DemoMode" => array ("FriendlyName" => "<strong>DEMO Mode</strong>", "Type" => "dropdown", "Options" => $YesNoOptions, "Description" => $DemoModeLabel, "Default" => 'off'),
        ));

    return $configarray;
}

// Show in admin panel in addon menu page
function caasify_output($vars) {

    if(!empty($vars['version'])){
        $version = $vars['version'];
        $text = '<h2> Version : ' . $version . '</h2>';
        echo($text);
    }

    $text = '
            <p>
                <span style="font-weight: 800 !important;">Caasify</span> is an unique solution for Data Centers and Hosting companies to meet in unified hosting marketplace.
            </p>
        ';
    echo($text);
    
    $text = '
            <p>You can always get the latest version from the <a href="https://github.com/caasify/Caasify-WHMCS-Module" style="font-weight: 800 !important;" target="_blank">Caasify git repository</a></p>
            <p>To learn how to use Caasify modules, please check out the 
                <a href="https://caasify.com/documentation?topic=3#topic" style="font-weight: 800 !important;" target="_blank"> Caasify documentation page</a> 
                or download
                <a href="https://update.caasify.com/whmcs/howtoinstall.pdf" style="font-weight: 800 !important;" target="_blank">installation document</a>
            </p>
            ';
    echo($text);

    
    // show error if config is empty or there is any error
    $ModuleConfigArray = caasify_get_config();
    if($ModuleConfigArray['errorMessage']){
        $text = '<pre><p style="color:red" class="h5">' . $ModuleConfigArray['errorMessage'] . '</p></pre>';
        echo($text);
    }
    
    $configs = caasify_get_config();
    $systemUrl = $configs['systemUrl'];
    if(empty($systemUrl)){
        $systemUrl = '/';
    }

    $iframe = '<iframe src="' . $systemUrl . '/caasifyupdatepage.php" frameborder="0" class="iframe"></iframe><style>.iframe{width:100%; height: 550px;}</style>';
    echo $iframe;

    

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

    $configs = caasify_get_config();
    $BackendUrl = $configs['BackendUrl'];
    if(empty($BackendUrl)){
        echo 'can not find BackendUrl to construct controller <br>';
        return false;
    }   
    
    $DevelopeMode = $config['DevelopeMode'];
    if(empty($DevelopeMode)){
        $DevelopeMode = 'off';
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


