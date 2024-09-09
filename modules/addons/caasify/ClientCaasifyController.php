<?php
use WHMCS\Database\Capsule;
use PG\Request\Request;

class ClientCaasifyController
{
    protected $BackendUrl;
    protected $ResellerToken;
    protected $UserToken;
    protected $CaasifyUserId;
    protected $WhUserId;
    protected $DemoMode;

    public function __construct($BackendUrl, $ResellerToken, $UserToken, $CaasifyUserId, $WhUserId, $DemoMode)
    {
        $BackendUrl = str_replace(' ', '', $BackendUrl);
        $BackendUrl = preg_replace('/\s+/', '', $BackendUrl);        
        $this->BackendUrl = $BackendUrl;
        $this->ResellerToken = $ResellerToken;
        $this->UserToken = $UserToken;   
        $this->CaasifyUserId = $CaasifyUserId;   
        $this->WhUserId = $WhUserId;   
        $this->DemoMode = $DemoMode;   
    }

    public function pageIndex()
    {   
        return ['templatefile' => 'views/index'];
    }

    public function pageCreate()
    {
        return ['templatefile' => 'views/create'];
    }

    public function pageView()
    {
        return ['templatefile' => 'views/view'];
    }
    
    public function pageFinance()
    {
        return ['templatefile' => 'views/finance'];
    }
    
    public function pageReseller()
    {
        return ['templatefile' => 'views/reseller'];
    }

    public function CaasifyGetUsertoken()
    {
        $UserToken = $this->UserToken;
        
        if(empty($UserToken)){
            $response = [
                'message' => 'Token not founded',
            ];    
        } else {
            $response = [
                'data' => $UserToken,
            ];
        }

        $this->response($response);
    }

    public function WhmcsUserInfo()
    {
        $WhUserId = $this->WhUserId;
        $response = caasify_get_whmcs_user($WhUserId);
        $this->response($response);
    }

    public function WhmcsCurrencies()
    {
        $response = caasify_get_Whmcs_Currencies();
        $this->response($response);
    }

    public function UserOrders()
    {
        $UserToken = $this->UserToken;
        $response = null;
        if($UserToken){
            $response = $this->sendUserOrdersRequest($UserToken);
        }
        
        $this->response($response);
    }

    public function sendUserOrdersRequest($UserToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Date-Humanize' => 1,
            'Authorization' => 'Bearer ' . $UserToken
        ]; 

        $address = [
            $BackendUrl, 'api', 'orders'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyUserInfo()
    {
        $UserToken = $this->UserToken;
        $response = null;

        if($UserToken){
            $response = $this->sendCaasifyUserInfoRequest($UserToken);
        }
        $this->response($response);
    }

    public function sendCaasifyUserInfoRequest($UserToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];

        $address = [
            $BackendUrl, 'api', 'profile', 'show'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyResellerUserInfo()
    {
        $UserToken = $this->UserToken;
        $response = null;

        if($UserToken){
            $response = $this->sendCaasifyResellerUserInfoRequest($UserToken);
        }
        $this->response($response);
    }

    public function sendCaasifyResellerUserInfoRequest($UserToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];

        $address = [
            $BackendUrl, 'api', 'profile', 'show'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }
    
    public function TheCaasifyResellerInfo()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        if($ResellerToken){
            $response = $this->sendTheCaasifyResellerInfoRequest($ResellerToken);
        }
        $this->response($response);
    }

    public function sendTheCaasifyResellerInfoRequest($ResellerToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $address = [
            $BackendUrl, 'api', 'profile', 'show'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyGetDataCenters()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        if($ResellerToken){
            $response = $this->sendCaasifyGetDataCentersRequest($ResellerToken);
        }
        $this->response($response);
    }

    public function sendCaasifyGetDataCentersRequest($ResellerToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $address = [
            $BackendUrl, 'api', 'reseller', 'common', 'categories'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }
    
    public function CaasifyGetPlans()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        $CategoryID = caasify_get_post('CategoryID');
        
        if($ResellerToken && $CategoryID){
            $response = $this->sendCaasifyGetPlansRequest($ResellerToken, $CategoryID);
            $this->response($response);
        }
    }

    public function sendCaasifyGetPlansRequest($ResellerToken, $CategoryID)
    {
        $BackendUrl = $this->BackendUrl;
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];
        
        $params = http_build_query([
            'category' => $CategoryID,
        ]);
        
        $address = [
            $BackendUrl, 'api', 'reseller', 'common', 'products', "?{$params}"
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyCreateOrder()
    {
        $UserToken = $this->UserToken;
        $params = caasify_get_post_array_all();
        $response = null;
        
        $DemoMode = $this->DemoMode;
        if(isset($DemoMode) && $DemoMode == 'off'){
            if($UserToken && $params){
                $response = $this->sendCaasifyCreateOrderRequest($UserToken, $params);
            }
        }

        $this->response($response);
    }  
    
    public function sendCaasifyCreateOrderRequest($UserToken, $params)
    {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'api', 'orders', 'create'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function LoadOrder()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');
        
        if($UserToken && $orderID){
            $response = $this->sendLoadOrderRequest($UserToken, $orderID);
        }
        
        $this->response($response);
    }

    public function sendLoadOrderRequest($UserToken, $orderID)
    {

        $headers = [
            'Accept' => 'application/json',
            'Date-Humanize' => 1,
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'api', 'orders', $orderID, 'show'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }
    
    public function CaasifyGetOrderViews()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');

        if($UserToken && $orderID){
            $response = $this->sendOrderViewsRequest($UserToken, $orderID);
        }

        $this->response($response);
    }

    public function sendOrderViewsRequest($UserToken, $orderID)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $orderID, 'views'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyOrderDoAction()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');
        $button_id = caasify_get_post('button_id');

        if($UserToken && $orderID && $button_id){
            $response = $this->sendOrderAction($UserToken, $orderID, $button_id);
        }

        $this->response($response);
    }

    public function sendOrderAction($UserToken, $orderID, $button_id)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $params = array(
            'button_id' => $button_id,
        );

        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $orderID, 'action'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function CaasifyRequestNewView()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');

        if($UserToken && $orderID){
            $response = $this->sendNewViewRequest($UserToken, $orderID);
        }

        $this->response($response);
    }

    public function sendNewViewRequest($UserToken, $orderID)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $orderID, 'view'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyActionsHistory()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');

        if($UserToken && $orderID){
            $response = $this->sendActionsHistory($UserToken, $orderID);
        }

        $this->response($response);
    }

    public function sendActionsHistory($UserToken, $orderID)
    {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $orderID, 'actions'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyOrderTraffics()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');

        if($UserToken && $orderID){
            $response = $this->SendOrderTraffics($UserToken, $orderID);
        }

        $this->response($response);
    }

    public function SendOrderTraffics($UserToken, $orderID)
    {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'monitoring', 'orders', $orderID, 'traffic'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    // create invoie form modal in caasify
    // create invoice and record it on database
    public function CreateNewUnpaidInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        // validate charge amount
        if(isset($requestData['Chargeamount'])){
            $Chargeamount = $requestData['Chargeamount'];
        } else {
            $message = 'charge amount did not send';
            $this->response($message); 
            return false;
        }
        
        // validate ratio
        if(isset($requestData['Ratio'])){
            $Ratio = $requestData['Ratio'];
        } else {
            $message = 'Ratio did not send';
            $this->response($message); 
            return false;
        }
        
        // validate user id
        if(isset($requestData['CaasifyUserId'])){
            $CaasifyUserId = $requestData['CaasifyUserId'];
        } else {
            $message = 'CaasifyUserId did not send';
            $this->response($message); 
            return false;
        }
                
        $WhUserId = $this->WhUserId;

        if(empty($Ratio) || empty($Chargeamount) || empty($WhUserId) | empty($CaasifyUserId)){
            $message = 'ratio, or amount, or user id is not defined';
            $this->response($message); 
            return false;
        }

        $currentDateTime = date('Y-m-d H:i:s');
        $nextDay = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +1 day'));

        if(empty($currentDateTime)){
            $currentDateTime = null;
        }
        
        if(empty($nextDay)){
            $nextDay = null;
        }

        $command = 'CreateInvoice';
        $postData = array(
            'userid' => $WhUserId,
            'status' => 'Unpaid',
            'taxrate' => '0',
            'date' => $currentDateTime,
            'duedate' => $nextDay,
            'itemdescription1' => 'Cloud Account Charging',
            'itemamount1' => $Chargeamount,
            'itemtaxed1' => '0',
            'autoapplycredit' => '0',
        );

        $results = localAPI($command, $postData);

        if($results['result'] == 'success'){
            $invoiceid = $results['invoiceid'];
        } else {
            $message = $results['result'];
            $this->response($message); 
            return false;
        }

        if(empty($invoiceid)){
            $message = 'did not fetch inovice ID form whmcs';
            $this->response($message); 
            return false;
        }
        
        $params = [
            'whuserid' => $WhUserId, 
            'caasifyid' => $CaasifyUserId, 
            'ratio' => $Ratio, 
            'invoiceid' => $invoiceid, 
            'chargeamount' => $Chargeamount,
            'real_charge_amount' => null,
            'commission' => null,
            'transactionid' => null,
            'created_at' => $currentDateTime,
            'updated_at' => $nextDay,
        ];

        try {
            Capsule::table('tblcaasify_invoices')->insert($params);
        } catch (\Exception $e) {
            $message = 'Error inserting user info into data base in handling  <br>';
            $this->response($message); 
            return false;
        }
    
        $this->response($results); 
    }
    
    public function ResellerCreateNewUnpaidInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);        
        if(isset($requestData['Chargeamount'])){
            $Chargeamount = $requestData['Chargeamount'];
        } else {
            $message = 'Charge amount did not send';
            $this->response($message); 
            return false;
        }
        
        if(isset($requestData['Ratio'])){
            $Ratio = $requestData['Ratio'];
        } else {
            $message = 'Ratio did not send';
            $this->response($message); 
            return false;
        }

        if(isset($requestData['SelectedGetway'])){
            $SelectedGetway = $requestData['SelectedGetway'];
        } else {
            $message = 'Can not access SelectedGetway';
            $this->response($message); 
            return false;
        }

        if(isset($requestData['CaasifyUserId'])){
            $CaasifyUserId = $requestData['CaasifyUserId'];
        } else {
            $message = 'CaasifyUserId did not send';
            $this->response($message); 
            return false;
        }

        if(isset($SelectedGetway) && $SelectedGetway == 'Stripe' && isset($Chargeamount)){
            $GatewayCommisionLabel = 'Stripe Commission 2.9% + 0.30 Euro';
            $GatewayCommisionValue = 0.30 + (0.029 * $Chargeamount);
        } else {
            $GatewayCommisionLabel = 'Gateway Commission';
            $GatewayCommisionValue = 0;
        }

        $WhUserId = $this->WhUserId;
        if(empty($Ratio) || empty($Chargeamount) || empty($WhUserId) | empty($CaasifyUserId)){
            $message = 'ratio, or amount, or user id is not defined';
            $this->response($message); 
            return false;
        }

        $currentDateTime = date('Y-m-d H:i:s');
        $nextDay = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +1 day'));

        if(empty($currentDateTime)){
            $currentDateTime = null;
        }
        
        if(empty($nextDay)){
            $nextDay = null;
        }

        $command = 'CreateInvoice';
        $postData = array(
            'userid' => $WhUserId,
            'status' => 'Unpaid',
            'taxrate' => '0',
            'paymentmethod' => $SelectedGetway,
            'date' => $currentDateTime,
            'duedate' => $nextDay,
            'itemdescription1' => 'Cloud Account Charging',
            'itemamount1' => $Chargeamount,
            'itemtaxed1' => '0',
            'itemdescription2' => $GatewayCommisionLabel,
            'itemamount2' => $GatewayCommisionValue,
            'itemtaxed2' => '0',
            'autoapplycredit' => '0',
        );
        $results = localAPI($command, $postData);

        if($results['result'] == 'success'){
            $invoiceid = $results['invoiceid'];
        } else {
            $message = $results['result'];
            $this->response($message); 
            return false;
        }

        if(empty($invoiceid)){
            $message = 'did not fetch inovice ID form whmcs';
            $this->response($message); 
            return false;
        }
        
        $params = [
            'whuserid' => $WhUserId, 
            'caasifyid' => $CaasifyUserId, 
            'ratio' => $Ratio, 
            'invoiceid' => $invoiceid, 
            'chargeamount' => $Chargeamount,
            'real_charge_amount' => null,
            'commission' => null,
            'transactionid' => null,
            'created_at' => $currentDateTime,
            'updated_at' => $nextDay,
        ];

        try {
            Capsule::table('tblcaasify_invoices')->insert($params);
        } catch (\Exception $e) {
            $message = 'Error inserting user info into data base in handling  <br>';
            $this->response($message); 
            return false;
        }

        $this->response($results); 
    
    }

    public function CreateUnpaidInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E01-Create Invoice)';
        }

        $CaasifyUserId = $this->CaasifyUserId;
        $WhUserId = $this->WhUserId;
        $currentDateTime = date('Y-m-d');
        $nextDay = date('Y-m-d', strtotime($currentDateTime . ' +1 day'));
        
        if(isset($chargeamount) && isset($WhUserId)){
            $command = 'CreateInvoice';
            $postData = array(
                'userid' => $WhUserId,
                'taxrate' => '0',
                'date' => $currentDateTime,
                'duedate' => $nextDay,
                'itemdescription1' => 'Charge Caasify Account',
                'itemamount1' => $chargeamount,
                'itemtaxed1' => '0',
                'notes' => 'Caasify: WhUserId = ' . $WhUserId . ' , CaasifyUserId = ' . $CaasifyUserId,
                'autoapplycredit' => '0',
            );
            $results = localAPI($command, $postData);
            $this->response($results); 
        } 
    }

    public function markCancelInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'Can not access Invoice Id (E02-Mark Cancel)';
        }
        
        $CaasifyUserId = $this->CaasifyUserId;
        $WhUserId = $this->WhUserId;
        $currentDateTime = date('Y-m-d');

        $command = 'UpdateInvoice';
            $postData = array(
                'invoiceid' => $invoiceid,
                'status' => 'Cancelled',
                'date' => $currentDateTime,
                'notes' => 'Caasify: WhUserId = ' . $WhUserId . ' , CaasifyUserId = ' . $CaasifyUserId,
            );
            $results = localAPI($command, $postData);
            $this->response($results); 
    }

    public function chargeCaasify()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'can not access invoice id (E03-Charge Caasify)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E03-Charge Caasify)';
        }

        $CaasifyUserId = $this->CaasifyUserId;
        if(empty($CaasifyUserId)){
            return false;
        }
        
        $ResellerToken = $this->ResellerToken;
    

        $status = caasify_get_mycaasify_status();

        if(isset($status) && $status == 'on'){
            $response = $this->sendResellerChargeCaasifyRequest($CaasifyUserId, $chargeamount, $invoiceid);
        } else {
            $response = $this->sendChargeCaasifyRequest($CaasifyUserId, $chargeamount, $invoiceid);
        }
        $this->response($response);
    }

    public function sendChargeCaasifyRequest($CaasifyUserId, $chargeamount, $invoiceid)
    {
        $ResellerToken = $this->ResellerToken;
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $params = [
            'amount' => $chargeamount,
            'type' => 'balance',
            'reference' => $invoiceid,
            'status' => 'paid'
        ];

        $address = [
            $BackendUrl, 'api', 'users', $CaasifyUserId, 'transactions', 'increase'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function resellerChargeCaasify()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'can not access invoice id (E03-Charge Caasify)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E03-Charge Caasify)';
        }

        $CaasifyUserId = $this->CaasifyUserId;
        if(empty($CaasifyUserId)){
            return false;
        }
        
        $ResellerToken = $this->ResellerToken;
    
        $response = $this->sendResellerChargeCaasifyRequest($CaasifyUserId, $chargeamount, $invoiceid);
        $this->response($response);
    }

    public function sendResellerChargeCaasifyRequest($CaasifyUserId, $chargeamount, $invoiceid)
    {
        $ResellerToken = $this->ResellerToken;
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $params = [
            'amount' => $chargeamount,
            'type' => 'balance',
            'reference' => $invoiceid,
            'status' => 'paid'
        ];

        $address = [
            $BackendUrl, 'api', 'backend', 'users', $CaasifyUserId, 'transactions', 'increase'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }
    
    public function applyTheCredit()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'can not access user id (E04-Apply Credit)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E04-Apply Credit)';
        }

        if(isset($chargeamount) && isset($invoiceid)){
            $command = 'ApplyCredit';
            $postData = array(
                'invoiceid' => $invoiceid,
                'amount' => $chargeamount,
            );

            $results = localAPI($command, $postData);
            $this->response($results); 
        } 
    }  


    public function CaasifyExpenseDates()
    {
        $UserToken = $this->UserToken;
        $response = null;

        if($UserToken){
            $response = $this->sendCaasifyExpenseDatesRequest($UserToken);
        }
        $this->response($response);
    }

    public function sendCaasifyExpenseDatesRequest($UserToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];

        $address = [
            $BackendUrl, 'api', 'report', 'expense', 'dates'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }


    public function CaasifyGetExpenses()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        $year = caasify_get_post('year');
        $month = caasify_get_post('month');
        
        if($ResellerToken && $year && $month){
            $response = $this->sendCaasifyGetExpensesRequest($ResellerToken, $year, $month);
            $this->response($response);
        }
    }

    public function sendCaasifyGetExpensesRequest($ResellerToken, $year, $month)
    {

        $BackendUrl = $this->BackendUrl;
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];
        
        $address = [
            $BackendUrl, 'api', 'report', 'expense', $year, $month, 'orders'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }


    public function response($response)
    {
        header('Content-Type: application/json');
        $response = json_encode($response);
        exit($response);
    }

    public function handle($action)
    {
        $class = new ReflectionClass($this);
        $method = $class->getMethod($action);
        if ($method) {
            return $method->invoke($this);
        }
    }

}