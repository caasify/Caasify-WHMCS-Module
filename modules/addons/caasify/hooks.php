<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;
use WHMCS\User\Alert;

$path = dirname(__FILE__);
require_once $path . '/AdminCaasifyoutputController.php';
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
if($userLogedIn == true) {        
    // Caasify Marketplace menu in main manu
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
    // Caasify Marketplace menu in submenu of services
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
} else {
    // VPS Pricing menu in submenu of services
    add_hook('ClientAreaPrimaryNavbar', 1, function ($primaryNavbar) {
        /** @var \WHMCS\View\Menu\Item $primaryNavbar */

        $config = caasify_get_config_decoded();
        $VpsPricingEnabled = $config['VpsPricingEnabled'];
        $VpsPricingMenuTitle = $config ['VpsPricingMenuTitle'];

        if (!isset($VpsPricingEnabled)) {
            $VpsPricingEnabled = 'on';
        }

        if (!isset($VpsPricingMenuTitle)) {
            $VpsPricingMenuTitle = 'VPS Pricing';
        }
        
        if($VpsPricingEnabled == 'on'){
            $newMenu = $primaryNavbar->addChild(
                'caasifyvpspricing',
                array(
                    'name' => 'VPS-Pricing',
                    'label' => $VpsPricingMenuTitle,
                    'uri' => 'vpspricing.php',
                    'order' => 99,
                    'icon' => '',
                )
            );
        }
    
    });
}

add_hook('ClientAreaPage', 100, function ($params) {
    // create invoice data base in client side
    $invoiceDatabaseStatus = cassify_create_invoice_table_database();
    if(isset($invoiceDatabaseStatus) && $invoiceDatabaseStatus != true){
        echo('<h4 style="color:red;">can not fine invoice table, call your admin</h4>');
        return false;
    }

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

// TODO:here is the place we add controler for admin output
add_hook('AdminAreaPage', 1, function($vars) {
    // Check if it is admin
    $admin = caasify_get_session('adminid');
    if (empty($admin)) {
        return false;
    }
    
    $action = caasify_get_query('adminuotputaction');
    
    if(isset($action)){
        $controller = new AdminCaasifyoutputController();
        return $controller->handle($action);
    }
    
});

add_hook('AdminAreaClientSummaryPage', 1, function ($vars) {

    // create invoice data base in admin panel
    $invoiceDatabaseStatus = cassify_create_invoice_table_database();
    if(isset($invoiceDatabaseStatus) && $invoiceDatabaseStatus != true){
        echo('<h4 style="color:red;">can not fine invoice table, call your admin</h4>');
        return false;
    }

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
        <style type="text/css"> .caasify{width: 100%; height: 400px;border: none;}</style>
    ';

    return $value;
});

if(isset($MyCaasifyStatus) && $MyCaasifyStatus == 'on'){
    add_hook('InvoiceCreated', 1, function($vars) {

        $invoiceid = $vars['invoiceid'];    
        if (empty($invoiceid)) {
            return false;
        }

        $CloudAccountChargingRecorde = Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('description', 'CsfUserBalance')
            ->first();

        if(empty($CloudAccountChargingRecorde)){        
            return false;
        }

        $chargeAmount = $CloudAccountChargingRecorde->amount;
        if(empty($chargeAmount) || $chargeAmount == 0){
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


        if ($paymentmethod == 'paypal') {
            $NewCommissionAmount = ($chargeAmount * 0.05) + 0.30;
            $NewDescription = "Paypal Commission 5% + 0.30";
        } else if ($paymentmethod == 'stripe') {
            $NewCommissionAmount = ($chargeAmount * 0.03) + 0.30;
            $NewDescription = "Gateway Commission 3% + 0.30 Euro";
        } else {
            $NewCommissionAmount = 0;
            $NewDescription = "Gateway has no Commission";
        }


        if($chargeAmount && $NewCommissionAmount && $NewDescription ){
            try{
                $NewSubtotal = 0;

                Capsule::table('tblinvoiceitems')
                    ->where('invoiceid', $invoiceid)
                    ->whereRaw('LOWER(description) LIKE ?', ['%commission%'])
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

                    $NewSubtotal = $chargeAmount + $NewCommissionAmount;
                }

                if($NewSubtotal != 0){
                    Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                        'subtotal' => $NewSubtotal,
                        'total' => $NewSubtotal
                    ]);
                } else {
                    Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                        'subtotal' => $chargeAmount,
                        'total' => $chargeAmount
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
        
        $CloudAccountChargingRecorde = Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('description', 'CsfUserBalance')
            ->first();

        if(empty($CloudAccountChargingRecorde)){        
            return false;
        }

        $ChargeAmount = $CloudAccountChargingRecorde->amount;
        if(empty($ChargeAmount) || $ChargeAmount == 0){
            return false;
        }

        Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->whereRaw('LOWER(description) LIKE ?', ['%commission%'])
            ->delete();

        $result = Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
            'subtotal' => $ChargeAmount,
            'total' => $ChargeAmount
        ]);

        
        CaasifyHandleCommissionDataBase($invoiceid, $paymentmethod);

    });


    function CaasifyHandleCommissionDataBase($invoiceid, $paymentmethod){

        $CloudAccountChargingRecorde = Capsule::table('tblinvoiceitems')
            ->where('invoiceid', $invoiceid)
            ->where('description', 'CsfUserBalance')
            ->first();

        if(empty($CloudAccountChargingRecorde)){        
            return false;
        }

        $ChargeAmount = $CloudAccountChargingRecorde->amount;
        if(empty($ChargeAmount) || $ChargeAmount == 0){
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

        if ($paymentmethod == 'paypal') {
            $NewCommissionAmount = ($ChargeAmount * 0.05) + 0.30;
            $NewDescription = "Paypal Commission 5%";
        } else if ($paymentmethod == 'stripe') {
            $NewCommissionAmount = ($ChargeAmount * 0.03) + 0.30;
            $NewDescription = "Gateway Commission 3% + 0.30 Euro";
        }

        try{
            $NewSubtotal = 0;
            Capsule::table('tblinvoiceitems')
                ->where('invoiceid', $invoiceid)
                ->whereRaw('LOWER(description) LIKE ?', ['%commission%'])
                ->delete();
            
        
            Capsule::table('tblinvoiceitems')->insert([
                'invoiceid' => $invoiceid,
                'userid' => $userid,
                'description' => $NewDescription,
                'type' => 'Commission',
                'amount' => $NewCommissionAmount,
                'taxed' => 0
            ]);

            $NewSubtotal = $ChargeAmount + $NewCommissionAmount;
        

            if($NewSubtotal != 0){
                Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                    'subtotal' => $NewSubtotal,
                    'total' => $NewSubtotal
                ]);
            } else {
                Capsule::table('tblinvoices')->where('id', $invoiceid)->update([
                    'subtotal' => $ChargeAmount,
                    'total' => $ChargeAmount
                ]);
            }
            
        } catch (Exception $e) {
            echo('Error to run handleCommissionDataBase');
            return false;
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
        $invoice = localAPI($command, $postData);
    }

    $items = $invoice['items']['item'];
    foreach ($items as $item) {
        if($item['description'] == 'CsfUserBalance'){
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

    $invoiceTable = cassify_getinfo_invoice_table($invoiceid);
    $Ratio = $invoiceTable->ratio;
    if(empty($Ratio)){
        echo('can not find Ratio in invoiceTable');
        return false;
    }

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
    
    $MyCaasifyStatus = caasify_get_mycaasify_status();
    if(!isset($MyCaasifyStatus) || $MyCaasifyStatus != 'on'){
        $MyCaasifyStatus = 'off';
    } else {
        $MyCaasifyStatus = 'on';
    }

    if(isset($MyCaasifyStatus) && $MyCaasifyStatus == 'on'){
        $CreateTransaction = caasify_charge_Reseller_from_invoice_hook($ResellerToken, $BackendUrl, $CaasifyUserId, $ChargeAmountInCloudCurr, $invoiceid);
    } else {
        $CreateTransaction = caasify_charge_user_from_invoice_hook($ResellerToken, $BackendUrl, $CaasifyUserId, $ChargeAmountInCloudCurr, $invoiceid);
    }

    $KeyMsg = 'CaasifyChargingMsg' . $invoiceid;
    $KeyStatus = 'CaasifyChargingStatus' . $invoiceid;
    $apiChargeResponse = 'apiChargeResponse' . $invoiceid;
    
    $message = property_exists($CreateTransaction, 'message');
    if (!empty($message) || empty($CreateTransaction)) {     
        $logMsg = 'E243: Invoice ' . $invoiceid . ' for User ' . $WhUserId . ' has failed';
        Caasify_Set_Log($logMsg . ' (Error: ' . $CreateTransaction->message . ')');
        session_start();
        unset($_SESSION[$KeyStatus]);
        unset($_SESSION[$KeyMsg]);
        $_SESSION[$KeyStatus] = "fail";
        $_SESSION[$KeyMsg] = $logMsg;
        $_SESSION[$apiChargeResponse] = $CreateTransaction->message;
    } else {
        session_start();
        unset($_SESSION[$KeyStatus]);
        $_SESSION[$KeyStatus] = "success";
    }
    
    
    // write transaction id on data base
    if (empty($message) && isset($CreateTransaction) && isset($ChargeAmountInCloudCurr) && isset($Commission)) {
        if(isset($CreateTransaction->data->id)){
            $TransactionId = $CreateTransaction->data->id;
            $writeSuccessState = cassify_update_caasify_invoice_table($invoiceid, $TransactionId, $ChargeAmountInCloudCurr, $Commission);
            if(isset($writeSuccessState) && $writeSuccessState == false){
                echo('can not write invoice id into data base');
            }
        }
    }

});

// send alert on invoice page
add_hook('ClientAreaPageViewInvoice', 1, function($vars) {

    $invoiceid = $vars['invoiceid'];
    $KeyMsg = 'CaasifyChargingMsg' . $invoiceid;
    $KeyStatus = 'CaasifyChargingStatus' . $invoiceid;    
    $apiChargeResponse = 'apiChargeResponse' . $invoiceid;
    $payAmount = $vars['invoiceitems'][0]['rawamount'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'clearalert') {
        unset($_SESSION[$KeyMsg]);
        unset($_SESSION[$KeyStatus]);
        unset($_SESSION[$apiChargeResponse]);
        return false;
    }
    
    // find home page 
    $config = caasify_get_config_decoded();
    $systemUrl = $config['systemUrl'];
    if (empty($systemUrl)) {
        $systemUrl = '';
    }
    if(isset($systemUrl)){
        $HomePageAddress = $systemUrl . '/index.php?m=caasify&action=pageIndex';
    } else {
        $HomePageAddress = '/index.php?m=caasify&action=pageIndex';
    } 

    if(isset($_SESSION[$apiChargeResponse]) && ($_SESSION[$apiChargeResponse] == "The amount field must be at least 0.2." || $_SESSION[$apiChargeResponse] == "The amount field must be at least 0.1.")){
        $_SESSION[$apiChargeResponse] = "Charge amount must be larger than 1 €";
    }

    $SuccessMsg = "                       
        <!-- Invoice Paid Modal -->
        <div class='modal fade mt-5 pt-5' id='invoiceConfirmationModal' tabindex='-1' aria-labelledby='invoiceModalLabel' style='display: none;'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='invoiceModalLabel'>Invoice Confirmation</h5>
                    </div>
                    <div class='modal-body'>
                        Invoice has been paid. Do you want to proceed?
                    </div>
                    <div class='modal-footer'>
                        <form method='POST' action=''>
                            <input type='hidden' name='action' value='clearalert'>
                            <input type='hidden' name='payAmount' id='payAmount' value=$payAmount>
                            <button type='submit' class='btn btn-primary px-5 py-1' id='confirmInvoiceButton'>
                                Ok
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            // Function to show modal manually
            function showModal() {
                var modal = document.getElementById('invoiceConfirmationModal');
                modal.style.display = 'block';  // Make modal visible
                setTimeout(function() {
                    modal.classList.add('show');  // Add Bootstrap show class for animation
                    document.body.classList.add('modal-open');  // Prevent background scrolling
                    
                    // Focus on the first focusable element in the modal
                    document.getElementById('confirmInvoiceButton').focus();
                    
                    var backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';  // Create and show backdrop
                    document.body.appendChild(backdrop);
                }, 10);  // Delay to trigger CSS animations
            }

            // Function to hide modal manually
            function hideModal() {
                var modal = document.getElementById('invoiceConfirmationModal');
                modal.classList.remove('show');  // Remove show class to hide
                document.body.classList.remove('modal-open');  // Enable background scrolling
                var backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.classList.remove('show');
                    setTimeout(function() {
                        backdrop.remove();  // Remove backdrop after fade-out
                        modal.style.display = 'none';  // Finally hide modal completely
                    }, 200);  // Delay to let the fade-out animation complete
                } else {
                    modal.style.display = 'none';
                }
            }

            // Show modal on page load
            window.onload = function() {
                showModal();
            };

            // Handle close button and OK button click events to close the modal
            document.getElementById('confirmInvoiceButton').addEventListener('click', function() {
                hideModal();  // Close modal when OK button is clicked
            });
            
            document.getElementById('closeButton').addEventListener('click', function() {
                hideModal();  // Close modal when the close button is clicked
            });
        </script>

        <!-- Bootstrap CSS (optional) -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet'>

        "
    ;
    
    $FailMsg = "
            <div class='container' style='max-width: 920px;'>
                <div style='padding: 30px; background-color: #c42c2ceb;color: #f1fcff; text-align: center; border: 1px solid; margin: 20px; border-radius: 10px; max-width: 960px;'>
                    <div class=''>
                        <h3>
                            Failed !!!
                        </h3>
                        <h6>Payment for cloud account failed, Please send a support ticket with a screenshot of this page. </h6>
                        <h6 class='alert alert-danger my-4 py-2'> $_SESSION[$KeyMsg] ($_SESSION[$apiChargeResponse])</h6>
                    </div>
                    <div class='' style='padding-top: 20px;'>
                        <form method='POST' action=''>
                            <input type='hidden' name='action' value='clearalert'>
                            <button type='submit' class='btn btn-outline-light btn-sm'>
                                Do not show again
                            </button>
                            <a href='$HomePageAddress' class='btn btn-light btn-sm'>
                                Go to Home Page
                            </a>
                        </form>
                    </div>
                </div>
            </div>   
        "
    ;
    
    if (isset($_SESSION[$KeyStatus])) {
        if ($_SESSION[$KeyStatus] == "fail") {
            //echo($FailMsg);
        } else if ($_SESSION[$KeyStatus] == "success"){
            //echo($SuccessMsg);
        }
    }

});