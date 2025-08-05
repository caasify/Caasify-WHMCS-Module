<?php

// This file aims to get configs from WHMCS and use it inside module

// INCLUDE NEEDED FILES
$position = strpos($_SERVER['PHP_SELF'], "modules");
$directoryPath = substr($_SERVER['PHP_SELF'], 0, $position);
$DomainAddress = $_SERVER['HTTP_HOST'];
$Protocol = $_SERVER['REQUEST_SCHEME'];
$SiteAddress = $Protocol . '://' . $DomainAddress . $directoryPath;


// Read init and caasify in this config file to use methods and props
$root = $_SERVER['DOCUMENT_ROOT'];
$initAdress = $root . $directoryPath . "init.php";
$caasifyAddress = $root . $directoryPath . 'modules/addons/caasify/caasify.php';
require_once($initAdress);
require_once ($caasifyAddress);

// Get and Set Language
$templatelang = caasify_GetDefaulLanguage();
if(empty($templatelang)){
    $templatelang = 'English';
}

// Get Config to send to ConfigApi.php
$configs = caasify_get_config_encoded();

$systemUrl = rtrim($configs['systemUrl'], '/');
$BackendUrl = $configs['BackendUrl'];

// DevelopeMode
$DevelopeMode = $configs['DevelopeMode'];
if(!isset($DevelopeMode)){
    $DevelopeMode = 'off';
}

// Show Datacenter Name
$showDatacenterName = $configs['ShowDatacenterName'];

if (!isset($showDatacenterName)) {
    $showDatacenterName = 'off';
}

// VpsPricingEnabled
$VpsPricingEnabled = $configs['VpsPricingEnabled'];
if(!isset($VpsPricingEnabled)){
    $VpsPricingEnabled = 'on';
}

// VPNSectionMenuTitle
$VPNSectionMenuTitle = $configs['VPNSectionMenuTitle'];
if(!isset($VPNSectionMenuTitle)){
    $VPNSectionMenuTitle = 'VPN';
}

// VPNSectionEnabled
$VPNSectionEnabled = $configs['VPNSectionEnabled'];
if(!isset($VPNSectionEnabled)){
    $VPNSectionEnabled = 'on';
}

// resellerMode
$resellerMode = $configs['resellerMode'];
if(!isset($resellerMode)){
    $resellerMode = 'off';
}

// DemoMode
$DemoMode = $configs['DemoMode'];
if(!isset($DemoMode)){
    $DemoMode = 'off';
}

// ViewExchanges
$ViewExchanges = $configs['ViewExchanges'];
if(isset($ViewExchanges) && $ViewExchanges =='on'){
    $ChargeModuleDetailsViews = true;
} else {
    $ChargeModuleDetailsViews = false;
}


// CloudTopupLink
$CloudTopupLink = $configs['CloudTopupLink'];
if(!isset($CloudTopupLink)){
    $CloudTopupLink = '/clientarea.php?action=addfunds';
}

$MinBalanceAllowToCreate = $configs['MinBalanceAllowToCreate'];
if(!isset($MinBalanceAllowToCreate) || !is_numeric($MinBalanceAllowToCreate) ){
    $MinBalanceAllowToCreate = 1;
}


$MyCaasifyStatus = caasify_get_mycaasify_status();
if(!isset($MyCaasifyStatus) || $MyCaasifyStatus != 'on'){
    $MyCaasifyStatus = 'off';
} else {
    $MyCaasifyStatus = 'on';
}

?>