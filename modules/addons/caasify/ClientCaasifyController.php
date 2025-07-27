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

    public function WhmcsGateways()
    {
        $response = caasify_get_whmcs_gateways();

        $this->response(['data' => $response]);
    }

    public function WhmcsUserTickets()
    {
        $WhUserId = $this->WhUserId;

        $response = caasify_get_whmcs_user_tickets($WhUserId);

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

    public function UserTotalOrders()
    {
        $UserToken = $this->UserToken;

        $response = $this->sendUserTotalOrdersRequest($UserToken);

        $this->response($response);
    }

    public function sendUserTotalOrdersRequest($UserToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];

        $address = [
            $BackendUrl, 'api', 'report', 'order', 'active'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function UserTotalExpense()
    {
        $UserToken = $this->UserToken;

        $response = $this->sendUserTotalExpenseRequest($UserToken);

        $this->response($response);
    }

    public function sendUserTotalExpenseRequest($UserToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];

        $address = [
            $BackendUrl, 'api', 'report', 'expense', 'total'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
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

    protected function getJsonParamsFromRequest()
    {
        $data = file_get_contents('php://input');

        return json_decode($data, true);
    }

    public function CreateChargeInvoice()
    {
        $params = $this->getJsonParamsFromRequest();

        // Find amount
        $amount = caasify_get_array('amount', $params);

        if (empty($amount)) {
            return $this->response(['message' => 'The amount field is required']);
        }

        // Find gateway
        $gateway = caasify_get_array('gateway', $params);

        if (empty($gateway)) {
            return $this->response(['message' => 'The gateway field is required']);
        }

        // Find user ID
        $userId = autovm_get_array('userId', $params);

        if (!$userId) {
            return $this->response(['message' => 'The user field is required']);
        }

        // Find ratio
        $ratio = autovm_get_array('ratio', $params);

        if (!$ratio) {
            return $this->response(['message' => 'The ratio field is required']);
        }

        // Create invoice
        $params = [
            'userid' => $this->WhUserId, 'paymentmethod' => $gateway, 'itemamount1' => $amount, 'itemdescription1' => 'CsfUserBalance'
        ];

        $result = localAPI('CreateInvoice', $params);

        // Find invoice ID
        $invoiceId = autovm_get_array('invoiceid', $result);

        if (!$invoiceId) {
            return $this->response(['message' => 'Could not create invoice']);
        }

        // Create invoice
        $params = [
            'whuserid' => $this->WhUserId, 'caasifyid' => $userId, 'ratio' => $ratio, 'invoiceid' => $invoiceId, 'chargeamount' => $amount
        ];

        Capsule::table('tblcaasify_invoices')
            ->insert($params);

        return $this->response(['id' => $invoiceId]);
    }

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
            'itemdescription1' => 'CsfUserBalance',
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

        if(isset($SelectedGetway) && isset($Chargeamount)){
            if($SelectedGetway == 'stripe'){
                $GatewayCommisionLabel = 'Stripe Commission 3% + 0.30 Euro';
                $GatewayCommisionValue = (0.03 * $Chargeamount) + 0.30;
            } else if ($SelectedGetway == 'paypal'){
                $GatewayCommisionLabel = 'Paypal Commission 5%';
                $GatewayCommisionValue = 0.05 * $Chargeamount;
            } else {
                $GatewayCommisionLabel = 'Gateway Commission';
                $GatewayCommisionValue = 0;
            }
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
            'itemdescription1' => 'CsfUserBalance',
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
        $UserToken = $this->UserToken;
        $response = null;

        $year = caasify_get_post('year');
        $month = caasify_get_post('month');

        if($UserToken && $year && $month){
            $response = $this->sendCaasifyGetExpensesRequest($UserToken, $year, $month);
            $this->response($response);
        }
    }

    public function sendCaasifyGetExpensesRequest($UserToken, $year, $month)
    {

        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
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


    public function CaasifyGetFilterTerms()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        if($ResellerToken){
            $response = $this->sendCaasifyGetFilterTermsRequest($ResellerToken);
        }
        $this->response($response);
    }

    public function sendCaasifyGetFilterTermsRequest($ResellerToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $address = [
            $BackendUrl, 'api', 'common', 'terms'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyGetPlansFromFiltersTerm()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        $termsArr = caasify_get_post_array_all();

        if($ResellerToken){
            $response = $this->sendCaasifyGetPlansFromFiltersTermRequest($ResellerToken, $termsArr);
        }

        $this->response($response);
    }

    public function sendCaasifyGetPlansFromFiltersTermRequest($ResellerToken, $termsArr)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];


        if(empty($termsArr)){
            $address = [ $BackendUrl, 'api', 'reseller', 'common', 'products'];
        } else {

            foreach ($termsArr as $value) {
                if ($value[0] == '291') {
                    $params[] = 'term[1][]=' . urlencode($value[0]);
                }
                if (is_array($value)) {
                    foreach ($value as $type => $typeValues) {
                        foreach ($typeValues as $id) {
                            $params[] = 'term[' . $type .'][]=' . urlencode($id);
                        }
                    }
                }
            }

            $queryString = implode('&', $params);
            $address = [ $BackendUrl, 'api', 'candy', 'common', 'products', "?{$queryString}" ];
        }

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyGetRecomPlansForContinent()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        $termArray = caasify_get_post_array_all();
        if(!empty($termArray)){
            foreach ($termArray as $key => $value) {
                foreach ($value as $id) {
                    $params = ['terms[' . $id . ']' => $id];
                }
            }
        }

        if($ResellerToken){
            $response = $this->sendCaasifyGetRecomPlansForContinentRequest($ResellerToken, $params);
        }

        $this->response($response);
    }

    public function sendCaasifyGetRecomPlansForContinentRequest($ResellerToken, $params)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $address = [ $BackendUrl, 'api', 'candy', 'common', 'suggestion' ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function CaasifyGetVpnPlans()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        if($ResellerToken){
            $response = $this->sendCaasifyGetVpnPlansRequest($ResellerToken);
        }

        $this->response($response);
    }

    public function sendCaasifyGetVpnPlansRequest($ResellerToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $address = [ $BackendUrl, 'api', 'candy', 'common', 'products', "?type=vpn" ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyGetHostPlans()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        if($ResellerToken){
            $response = $this->sendCaasifyGetHostPlansRequest($ResellerToken);
        }

        $this->response($response);
    }

    public function sendCaasifyGetHostPlansRequest($ResellerToken)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $address = [ $BackendUrl, 'api', 'candy', 'common', 'products', "?type=host" ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }


    public function CaasifyVpnShow()
    {
        $UserToken = $this->UserToken;
        $response = null;

        $orderID = caasify_get_post('orderID');

        if($UserToken && $orderID){
            $response = $this->SendCaasifyVpnShow($UserToken, $orderID);
        }

        $this->response($response);
    }

    public function SendCaasifyVpnShow($UserToken, $orderID)
    {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];

        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'api', 'candy', 'orders', $orderID, 'vpn', 'show'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }
    /**
     * Validates a promotion code and calculates the final price after applying the promotion.
     *
     * @param request['code']    string   The promotion code to validate.
     * @param request['price']   float    The original invoice price before applying the promotion.
     *
     * @return array                       An associative array with the following keys:
     *                                       - 'status' (bool): Indicates whether the promotion code is valid (true) or not (false).
     *                                       - 'message' (string): Provides a success or error message explaining the result.
     *                                       - 'final_price' (float): The final invoice price after applying the promotion.
     *
     * Example:
     * Input: {"code": "DISCOUNT50", "price": 100.0}
     * Output: {"status": true, "message": "Successful", "final_price": 50.0}
     *
     */
    public function CaasifyValidatePromotion()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        $code = $requestData['code'];
        $price = $requestData['price'];

        $result = caasify_promotion_validation($code, $price , $this->WhUserId);

        $this->response(
            [
                "status" => $result[0],
                "message" => $result[1],
                "final_price" => $result[2],
            ]
        );
    }
}