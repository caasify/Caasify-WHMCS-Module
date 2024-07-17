<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;
use WHMCS\User\Alert;

$path = dirname(__FILE__);
require_once $path . '/AdminCaasifyController.php';
require_once $path . '/basics.php';

$CurrentUserSession = caasify_get_session('uid');
if(isset($CurrentUserSession) && $CurrentUserSession != ''){
    $userLogedIn = true;
} else {
    $userLogedIn = false;
}

$MyCaasifyStatus = caasify_get_mycaasify_status();
if(!isset($MyCaasifyStatus) || $MyCaasifyStatus != 'on'){
    $MyCaasifyStatus = 'off';
} else {
    $MyCaasifyStatus = 'on';
}

// Menu Hook
if(isset($MyCaasifyStatus) && $MyCaasifyStatus == 'on'){
    if($userLogedIn == true){

        // Remove extra menu
        add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
            /** @var \WHMCS\View\Menu\Item $primaryNavbar */
            
            if (!is_null($primaryNavbar->getChild('Home'))){
                $primaryNavbar->removeChild('Home');
            }
            
            if (!is_null($primaryNavbar->getChild('Store'))){
                $primaryNavbar->removeChild('Store');
            }
            
            if (!is_null($primaryNavbar->getChild('Announcements'))){
                $primaryNavbar->removeChild('Announcements');
            }
            
            if (!is_null($primaryNavbar->getChild('Knowledgebase'))){
                $primaryNavbar->removeChild('Knowledgebase');
            }
            
            if (!is_null($primaryNavbar->getChild('Network Status'))){
                $primaryNavbar->removeChild('Network Status');
            }
            
            if (!is_null($primaryNavbar->getChild('Marketplace'))){
                $primaryNavbar->removeChild('Marketplace');
            }
            
            if (!is_null($primaryNavbar->getChild('Services'))){
                $primaryNavbar->removeChild('Services');
            }
            
            if (!is_null($primaryNavbar->getChild('Domains'))){
                $primaryNavbar->removeChild('Domains');
            }



            if (!is_null($primaryNavbar->getChild('Support'))) {
                $servicesMenu = $primaryNavbar->getChild('Support');
                if (!is_null($servicesMenu->getChild('Announcements'))){
                    $servicesMenu->removeChild('Announcements');
                }
                if (!is_null($servicesMenu->getChild('Knowledgebase'))){
                    $servicesMenu->removeChild('Knowledgebase');
                }
                if (!is_null($servicesMenu->getChild('Downloads'))){
                    $servicesMenu->removeChild('Downloads');
                }
                if (!is_null($servicesMenu->getChild('Network Status'))){
                    $servicesMenu->removeChild('Network Status');
                }
            }
            
            if (!is_null($primaryNavbar->getChild('Billing'))) {
                $BillingMenu = $primaryNavbar->getChild('Billing');
                if (!is_null($BillingMenu->getChild('My Quotes'))){
                    $BillingMenu->removeChild('My Quotes');
                }
            }
            
            
        });        

        // Reseller menu
        add_hook('ClientAreaPrimaryNavbar', 1, function ($primaryNavbar) {
            /** @var \WHMCS\View\Menu\Item $primaryNavbar */

            $newMenu = $primaryNavbar->addChild(
                'uniqueMenuItemNameReseller',
                array(
                    'name' => 'Reseller',
                    'label' => 'Reseller',
                    'uri' => '/index.php?m=caasify&action=pageReseller',
                    'order' => 1,
                    'icon' => 'fas fa-home fa-fw',
                )
            );
        });

        // Cloud VPS menu
        add_hook('ClientAreaPrimaryNavbar', 1, function ($primaryNavbar) {
            /** @var \WHMCS\View\Menu\Item $primaryNavbar */
        
            $parentMenu = $primaryNavbar->addChild(
                'uniqueParentMenuItemNameCloudVPS',
                [
                    'name' => 'CloudVPS',
                    'label' => 'CloudVPS',
                    'uri' => '#',  // '#' makes it act as a dropdown trigger
                    'order' => 2,
                    'icon' => 'fas fa-cube fa-fw',
                ]
            );
        
            // Add the first child menu item
            $parentMenu->addChild(
                'CreateVPS',
                [
                    'name' => 'Create VPS',
                    'label' => 'Create VPS',
                    'uri' => '/modules/addons/caasify/views/view/create.php',
                    'order' => 1,
                    'icon' => '',
                ]
            );
        
            // Add the second child menu item
            $parentMenu->addChild(
                'uniqueSubMenuItemNameViewVPS',
                [
                    'name' => 'View VPS',
                    'label' => 'View VPS',
                    'uri' => '/index.php?m=caasify&action=pageIndex',
                    'order' => 2,
                    'icon' => '',
                ]
            );
        });

    } else {
        // Remove extra menu
        add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
            /** @var \WHMCS\View\Menu\Item $primaryNavbar */
            
            if (!is_null($primaryNavbar->getChild('Store'))){
                $primaryNavbar->removeChild('Store');
            }
            
            if (!is_null($primaryNavbar->getChild('Announcements'))){
                $primaryNavbar->removeChild('Announcements');
            }
            
            if (!is_null($primaryNavbar->getChild('Knowledgebase'))){
                $primaryNavbar->removeChild('Knowledgebase');
            }
            
            if (!is_null($primaryNavbar->getChild('Network Status'))){
                $primaryNavbar->removeChild('Network Status');
            }
            
            if (!is_null($primaryNavbar->getChild('Marketplace'))){
                $primaryNavbar->removeChild('Marketplace');
            }
            
            if (!is_null($primaryNavbar->getChild('Services'))){
                $primaryNavbar->removeChild('Services');
            }
            
            if (!is_null($primaryNavbar->getChild('Domains'))){
                $primaryNavbar->removeChild('Domains');
            }

        });
    }

} else {

    add_hook('ClientAreaPrimaryNavbar', 1, function ($primaryNavbar) {
        /** @var \WHMCS\View\Menu\Item $primaryNavbar */

        $config = caasify_get_config_decoded();

        $CaasifyMenuTitle = $config['CaasifyMenuTitle'];
        if (!isset($CaasifyMenuTitle) || !is_string($CaasifyMenuTitle)) {
            $CaasifyMenuTitle = 'Marketplace';
        }
        
        $CaasifyMenuPlace = $config['CaasifyMenuPlace'];
        if (!isset($CaasifyMenuPlace) || !is_string($CaasifyMenuPlace)) {
            $CaasifyMenuPlace = 'MainMenu';
        }
        
        if(isset($CaasifyMenuPlace) && $CaasifyMenuPlace == 'MainMenu'){
            $newMenu = $primaryNavbar->addChild(
                'uniqueMenuItemNameMarketplace',
                array(
                    'name' => 'Marketplace',
                    'label' => $CaasifyMenuTitle,
                    'uri' => '/index.php?m=caasify&action=pageIndex',
                    'order' => 99,
                    'icon' => '',
                )
            );
        }
    });


    add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
        /** @var \WHMCS\View\Menu\Item $primaryNavbar */
        if (!is_null($primaryNavbar->getChild('Services'))) {
            $servicesMenu = $primaryNavbar->getChild('Services');
            
            $config = caasify_get_config_decoded();

            $CaasifyMenuTitle = $config['CaasifyMenuTitle'];
            if (!isset($CaasifyMenuTitle) || !is_string($CaasifyMenuTitle)) {
                $CaasifyMenuTitle = 'Marketplace';
            }

            $CaasifyMenuPlace = $config['CaasifyMenuPlace'];
            if (!isset($CaasifyMenuPlace) || !is_string($CaasifyMenuPlace)) {
                $CaasifyMenuPlace = 'MainMenu';
            }

            if(isset($CaasifyMenuPlace) && $CaasifyMenuPlace == 'InsideServices'){
                // Add a new submenu item under Services
                $servicesMenu->addChild(
                    'uniqueSubMenuItemNameMarketplace2',
                    array(
                        'name' => 'Marketplace',
                        'label' => $CaasifyMenuTitle,
                        'uri' => '/index.php?m=caasify&action=pageIndex',
                        'order' => 99,
                        'icon' => '',
                    )
                );
            }
        }
    });

}

add_hook('ClientAreaPage', 100, function ($params) {
    $WhUserId = caasify_get_session('uid');
    if (empty($WhUserId)) {
        // echo 'can not find WhUserId to construct controller  in ClientAreaPage';
        return false;
    }

    $config = caasify_get_config_decoded();
    $ResellerToken = caasify_get_reseller_token();
    $BackendUrl = $config['BackendUrl'];

    if (empty($config)) {
        echo 'can not find config in ClientAreaPage <br>';
        return false;
    }

    if (empty($ResellerToken)) {
        echo 'can not find ResellerToken to construct controller in ClientAreaPage <br>';
        return false;
    }

    if (empty($BackendUrl)) {
        echo 'can not find BackendUrl to construct controller  in ClientAreaPage <br>';
        return false;
    }


    $UserToken = caasify_get_token_by_handling($ResellerToken, $BackendUrl, $WhUserId);
    if (empty($UserToken)) {
        echo 'can not get UserToken from handler func in Client hook <br>';
        return false;
    }
});

add_hook('AdminAreaClientSummaryPage', 1, function ($vars) {

    // Check if it is admin
    $admin = caasify_get_session('adminid');
    if (empty($admin)) {
        return false;
    }

    $config = caasify_get_config_decoded();
    $ResellerToken = caasify_get_reseller_token();
    $BackendUrl = $config['BackendUrl'];
    $WhUserId = $vars['userid'];

    if (empty($config)) {
        echo 'can not find config in AdminHook <br>';
        return false;
    }

    if (empty($ResellerToken)) {
        echo 'can not find ResellerToken to construct controller in AdminHook <br>';
        return false;
    }

    if (empty($BackendUrl)) {
        echo 'can not find BackendUrl to construct controller  in AdminHook <br>';
        return false;
    }

    if (empty($WhUserId)) {
        echo 'can not find WhUserId to construct controller  in AdminHook <br>';
        return false;
    }

    // GET token
    $UserToken = caasify_get_token_by_handling($ResellerToken, $BackendUrl, $WhUserId);
    if (empty($UserToken)) {
        echo 'can not get UserToken from handler func in AdminHook <br>';
        return false;
    }

    $CaasifyUserId = caasify_get_CaasifyUserId_from_WhmUserId($WhUserId);
    if (empty($CaasifyUserId)) {
        echo ('Can not find caasify user id by WhUserId in BD <br>');
        return false;
    }

    $DevelopeMode = $config['DevelopeMode'];
    if (empty($DevelopeMode)) {
        $DevelopeMode = 'off';
    }

    $action = caasify_get_query('action');
    if (!empty($action) && !empty($UserToken) && !empty($CaasifyUserId) && !empty($ResellerToken) && !empty($BackendUrl)) {
        try {
            $controller = new AdminCaasifyController($BackendUrl, $ResellerToken, $UserToken, $CaasifyUserId, $WhUserId);
            return $controller->handle($action);
        } catch (Exception $e) {
            if ($DevelopeMode == 'on') {
                echo "Error run AdminController in admin hook: <br>" . $e . "<br>";
                return false;
            } else {
                echo ('Error while run admin controler <br>');
                return false;
            }
        }
    }

    $systemUrl = $config['systemUrl'];
    if (empty($systemUrl)) {
        $systemUrl = '';
    }


    $link = $systemUrl . '/modules/addons/caasify/views/view/admin.php?userid=' . $WhUserId;
    $value = '
        <iframe src="' . $link . '" class="caasify"></iframe>
        <style type="text/css"> .caasify{width: 100%; height: 350px;border: none;}</style>
    ';

    return $value;
});

if(isset($MyCaasifyStatus) && $MyCaasifyStatus == 'on'){
    add_hook('InvoiceCreated', 1, function($vars) {

        $invoiceid = $vars['invoiceid'];    
        if (empty($invoiceid)) {
            return false;
        }

        $invoiceItemAddFund = Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('type', 'AddFunds')
            ->first();

        if(empty($invoiceItemAddFund)){        
            return false;
        }


        $AddFundsAmount = $invoiceItemAddFund->amount;
        if(empty($AddFundsAmount) || $AddFundsAmount == 0){
            return false;
        }

        $invoice = Capsule::table('tblinvoices')->where('id', $invoiceid)->first();
        if (empty($invoice)) {
            return false;
        }

        $userid = $invoice->userid;
        if(empty($userid)){
            return false;
        }
        
        $paymentmethod = $invoice->paymentmethod;
        if(empty($paymentmethod)){
            return false;
        }


        $NewCommissionAmount = 0;
        $NewDescription = '';

        if ($paymentmethod == 'paypalcheckout') {
            $NewCommissionAmount = ($AddFundsAmount * 0.034) + 0.35;
            $NewDescription = "Gateway Commission 3.4% + 0.35 Euro";
        } else if ($paymentmethod == 'stripe') {
            $NewCommissionAmount = ($AddFundsAmount * 0.029) + 0.30;
            $NewDescription = "Gateway Commission 2.9% + 0.30 Euro";
        } else if ($paymentmethod == 'mailin') {
            $NewCommissionAmount = 0;
            $NewDescription = "Gateway has no Commission";
        }


        if($AddFundsAmount && $NewCommissionAmount && $NewDescription ){
            try{
                $NewSubtotal = 0;

                Capsule::table('tblinvoiceitems')
                    ->where('invoiceid', $invoiceid)
                    ->where('type', 'commission')
                    ->delete();
                
                if($NewCommissionAmount != 0 && $NewDescription != ''){
                    Capsule::table('tblinvoiceitems')->insert([
                        'invoiceid' => $invoiceid,
                        'userid' => $userid,
                        'description' => $NewDescription,
                        'type' => 'Commission',
                        'amount' => $NewCommissionAmount,
                        'taxed' => 0
                    ]);

                    $NewSubtotal = $AddFundsAmount + $NewCommissionAmount;
                }

                if($NewSubtotal != 0){
                    Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                        'subtotal' => $NewSubtotal,
                        'total' => $NewSubtotal
                    ]);
                } else {
                    Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                        'subtotal' => $AddFundsAmount,
                        'total' => $AddFundsAmount
                    ]);
                }
                
            } catch (Exception $e) {
                echo('Error to run handleCommissionDataBase');
                return false;
            }
        }

    });




    add_hook('InvoiceChangeGateway', 1, function($vars) {

        $invoiceid = $vars['invoiceid'];
        $paymentmethod = $vars['paymentmethod'];

        if (empty($invoiceid)) {
            return false;
        }
        
        $invoiceItemAddFund = Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('type', 'AddFunds')
            ->first();

        if(empty($invoiceItemAddFund)){        
            return false;
        }

        $AddFundsAmount = $invoiceItemAddFund->amount;
        if(empty($AddFundsAmount) || $AddFundsAmount == 0){
            return false;
        }

        Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('type', 'commission')
            ->delete();

        $result = Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
            'subtotal' => $AddFundsAmount,
            'total' => $AddFundsAmount
        ]);

        CaasifyHandleCommissionDataBase($invoiceid, $paymentmethod);

    });


    function CaasifyHandleCommissionDataBase($invoiceid, $paymentmethod){

        $invoiceItemAddFund = Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('type', 'AddFunds')
            ->first();

        if(empty($invoiceItemAddFund)){        
            return false;
        }

        $AddFundsAmount = $invoiceItemAddFund->amount;
        if(empty($AddFundsAmount) || $AddFundsAmount == 0){
            return false;
        }

        $invoice = Capsule::table('tblinvoices')->where('id', $invoiceid)->first();
        if (empty($invoice)) {
            return false;
        }

        $userid = $invoice->userid;
        if(empty($userid)){
            return false;
        }

        $NewCommissionAmount = 0;
        $NewDescription = '';

        if ($paymentmethod == 'paypalcheckout') {
            $NewCommissionAmount = ($AddFundsAmount * 0.034) + 0.35;
            $NewDescription = "Gateway Commission 3.4% + 0.35 Euro";
        } else if ($paymentmethod == 'stripe') {
            $NewCommissionAmount = ($AddFundsAmount * 0.029) + 0.30;
            $NewDescription = "Gateway Commission 2.9% + 0.30 Euro";
        }
        
        if($AddFundsAmount && $NewCommissionAmount && $NewDescription ){
            try{
                $NewSubtotal = 0;

                Capsule::table('tblinvoiceitems')
                    ->where('invoiceid', $invoiceid)
                    ->where('type', 'commission')
                    ->delete();
                
                if($NewCommissionAmount != 0 && $NewDescription != ''){
                    Capsule::table('tblinvoiceitems')->insert([
                        'invoiceid' => $invoiceid,
                        'userid' => $userid,
                        'description' => $NewDescription,
                        'type' => 'Commission',
                        'amount' => $NewCommissionAmount,
                        'taxed' => 0
                    ]);

                    $NewSubtotal = $AddFundsAmount + $NewCommissionAmount;
                }

                if($NewSubtotal != 0){
                    Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                        'subtotal' => $NewSubtotal,
                        'total' => $NewSubtotal
                    ]);
                } else {
                    Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                        'subtotal' => $AddFundsAmount,
                        'total' => $AddFundsAmount
                    ]);
                }
                
            } catch (Exception $e) {
                echo('Error to run handleCommissionDataBase');
                return false;
            }
        }

    }
}

add_hook('InvoicePaid', 1, function($vars) {
    $invoiceid = $vars['invoiceid'];
    if(empty($invoiceid)){
        return false;
    }

    if(isset($invoiceid)){
        $command = 'GetInvoice';
        $postData = array(
            'invoiceid' => $invoiceid,
        );
        $invoice = localAPI($command, $postData, $adminUsername);
    }

    $items = $invoice['items']['item'];
    foreach ($items as $item) {
        if($item['description'] == 'Cloud Account Charging'){
            $RawAmountCharge = $item['amount'];
        }
    }
    if(!isset($RawAmountCharge)){
        return false;
    }

    $WhUserId = $invoice['userid'];
    if(!isset($WhUserId)){
        return false;
    }

    $notes = $invoice['notes'];
    if(!empty($notes)){
        if(strpos($notes, 'POAWMM') == false){
            return false;
        }    
        if(strpos($notes, 'R') == '0'){
            //
        } else {
            return false;
        }
    }

    preg_match('/R([0-9]+\.[0-9]+)POAWMM/', $notes, $matches);
    $Ratio = $matches[1];

    $config = caasify_get_config_decoded();
    $Commission = $config['Commission'];

    $ChargeAmountInCloudCurr = 100* ($RawAmountCharge * $Ratio)/(100 + $Commission);
    $BackendUrl = $config['BackendUrl'];
    $ResellerToken = caasify_get_reseller_token();
    $CaasifyUserId = caasify_get_CaasifyUserId_from_WhmUserId($WhUserId);

    if(!isset($WhUserId) || !isset($CaasifyUserId) || !isset($RawAmountCharge) || !isset($Ratio) || !isset($Commission)){
        return false;
    }

    if(!isset($ResellerToken) || !isset($BackendUrl) || !isset($CaasifyUserId)){
        return false;
    }

    $CreateTransaction = caasify_charge_user_from_invoice_hook($ResellerToken, $BackendUrl, $CaasifyUserId, $ChargeAmountInCloudCurr, $invoiceid);

    $KeyMsg = 'CaasifyChargingMsg' . $invoiceid;
    $KeyStatus = 'CaasifyChargingStatus' . $invoiceid;


    $message = property_exists($CreateTransaction, 'message');
    if (!empty($message) || empty($CreateTransaction)) {     
        $logMsg = 'Error 243: Invoice ' . $invoiceid . ' for WHMCS User ' . $WhUserId . ' has failed to charge the Cloud Account';
        Caasify_Set_Log($logMsg . ' (Error: ' . $CreateTransaction->message . ')');
        session_start();
        unset($_SESSION[$KeyStatus]);
        unset($_SESSION[$KeyMsg]);
        $_SESSION[$KeyStatus] = "fail";
        $_SESSION[$KeyMsg] = $logMsg;
    } else {
        session_start();
        unset($_SESSION[$KeyStatus]);
        $_SESSION[$KeyStatus] = "success";
    }
    
});

// send alert on invoice page
add_hook('ClientAreaPageViewInvoice', 1, function($vars) {

    $invoiceid = $vars['invoiceid'];
    $KeyMsg = 'CaasifyChargingMsg' . $invoiceid;
    $KeyStatus = 'CaasifyChargingStatus' . $invoiceid;    

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'clearalert') {
        unset($_SESSION[$KeyStatus]);
        unset($_SESSION[$KeyMsg]);
        return false;
    }

    if(isset($_SESSION[$KeyMsg])){
        $log = $_SESSION[$KeyMsg];
    } else {
        $log = '';
    }

    if(isset($systemUrl)){
        $HomePageAddress = $systemUrl . '/index.php?m=caasify&action=pageIndex';
    } else {
        $HomePageAddress = '/index.php?m=caasify&action=pageIndex';
    }
    $SuccessMsg = '
                <div class="container" style="max-width: 920px;">
                    <div style="padding: 30px;background-color: #2c64c4eb;color: #f1fcff;text-align: center;ter;border: 1px solid;margin: 20px;border-radius: 10px;max-width: 960px;">
                        <h3>
                            Charging your cloud account was successful
                        </h3>
                        <br>
                        <a href="'. $HomePageAddress .'" style="color: white;">
                            Go to Home Page
                        </a>
                    </div>
                </div>   
        '
    ;


    
    $FailMsg = '
            <div class="container" style="max-width: 920px;">
                <div style="padding: 30px;background-color: #c42c2ceb;color: #f1fcff;text-align: center;ter;border: 1px solid;margin: 20px;border-radius: 10px;max-width: 960px;">
                    <div class="row">
                        <h3>
                            Charging the Cloud Account Failed !!!
                        </h3>
                        <h6>Payment for cloud account failed, Please send a support ticket with a screenshot of this page. </h6>
                        <h6>' . $log . '</h6>
                    </div>
                    <div class="row" style="padding-top: 20px;">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="clearalert">
                            <button type="submit" class="btn btn-dark btn-sm">Do not show again</button>
                        </form>
                    </div>
                </div>
            </div>   
        '
    ;

    if (isset($_SESSION[$KeyStatus])) {
        if ($_SESSION[$KeyStatus] == "fail") {
            echo($FailMsg);
        } else if ($_SESSION[$KeyStatus] == "success"){
            echo($SuccessMsg);
        }
    }

});