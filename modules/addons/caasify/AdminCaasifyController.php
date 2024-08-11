<?php
use PG\Request\Request;
use WHMCS\Database\Capsule;

class AdminCaasifyController
{
    protected $BackendUrl;
    protected $ResellerToken;
    protected $UserToken;
    protected $CaasifyUserId;
    protected $WhUserId;
    
    public function __construct($BackendUrl, $ResellerToken, $UserToken, $CaasifyUserId, $WhUserId){
        $BackendUrl = str_replace(' ', '', $BackendUrl);
        $BackendUrl = preg_replace('/\s+/', '', $BackendUrl);        
        
        $this->BackendUrl = $BackendUrl;
        $this->ResellerToken = $ResellerToken;
        $this->UserToken = $UserToken;
        $this->CaasifyUserId = $CaasifyUserId;
        $this->WhUserId = $WhUserId;

        if(empty($BackendUrl) || empty($ResellerToken) || empty($UserToken) || empty($CaasifyUserId) || empty($WhUserId)){
            echo "Something is missed to init admin controller";
        }

    }


    public function admin_UserOrders()
    {
        $UserToken = $this->UserToken;
        $response = null;
        $page = caasify_get_post('page');
        if(empty($page)){
            $page = 1;
        }
        if($UserToken){
            $response = $this->admin_sendUserOrdersRequest($UserToken, $page);
        }
        
        $this->response($response);
    }

    public function admin_sendUserOrdersRequest($UserToken, $page)
    {
        $BackendUrl = $this->BackendUrl;

        $headers = [
            'Accept' => 'application/json',
            'Date-Humanize' => 1,
            'Authorization' => 'Bearer ' . $UserToken
        ]; 

        $address = [
            $BackendUrl, 'api', 'orders', '?page=' . $page
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function admin_CaasifyRessellerInfo()
    {
        $ResellerToken = $this->ResellerToken;
        $response = null;

        if($ResellerToken){
            $response = $this->admin_sendCaasifyUserInfoRequest($ResellerToken);
        }
        
        $this->response($response);
    }

    public function admin_SendRessellerInfo($ResellerToken, $page)
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

    public function admin_CaasifyUserInfo()
    {
        $UserToken = $this->UserToken;
        $response = null;

        if($UserToken){
            $response = $this->admin_sendCaasifyUserInfoRequest($UserToken);
        }
        
        $this->response($response);
    }

    public function admin_sendCaasifyUserInfoRequest($UserToken)
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

    public function admin_increaseChargeCaasify()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);        
        if($requestData['ChargeAmount']){
            $ChargeAmount = $requestData['ChargeAmount'];
        } else {
            echo 'can not access charge amount in admin controller <br>';
            return false;
        }

        $CaasifyUserId = $this->CaasifyUserId;
        if(empty($CaasifyUserId)){
            echo 'can not find CaasifyUserId in admin controller <br>';
            return false;
        }

        if(!empty($CaasifyUserId) && !empty($ChargeAmount)){
            $status = caasify_get_mycaasify_status();
            if(isset($status) && $status == 'on'){
                $response = $this->admin_sendResellerIncreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount);
            } else {
                $response = $this->admin_sendIncreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount);
            }

        } else {
            return false;
        }

        $this->response($response);
    }

    public function admin_sendIncreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount)
    {
        $ResellerToken = $this->ResellerToken;
        $BackendUrl = $this->BackendUrl;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $params = [
            'amount' => $ChargeAmount,
            'type' => 'balance',
            'invoiceid' => 'admin',
            'status' => 'paid'
        ];

        $address = [
            $BackendUrl, 'api', 'users', $CaasifyUserId, 'transactions', 'increase'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function admin_sendResellerIncreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount)
    {
        $ResellerToken = $this->ResellerToken;
        $BackendUrl = $this->BackendUrl;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $params = [
            'amount' => $ChargeAmount,
            'type' => 'balance',
            'invoiceid' => 'admin',
            'status' => 'paid'
        ];

        $address = [
            $BackendUrl, 'api', 'backend', 'users', $CaasifyUserId, 'transactions', 'increase'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }
    
    public function admin_DecreaseChargeCaasify()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);        
        if($requestData['ChargeAmount']){
            $ChargeAmount = $requestData['ChargeAmount'];
        } else {
            echo 'can not access charge amount in admin controller <br>';
            return false;
        }

        $CaasifyUserId = $this->CaasifyUserId;
        if(empty($CaasifyUserId)){
            echo 'can not find CaasifyUserId in admin controller <br>';
            return false;
        }

        if(!empty($CaasifyUserId) && !empty($ChargeAmount)){
            $status = caasify_get_mycaasify_status();
            if(isset($status) && $status == 'on'){
                $response = $this->admin_sendResellerDecreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount);
            } else {
                $response = $this->admin_sendDecreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount);
            }

        } else {
            return false;
        }

        $this->response($response);
    }

    public function admin_sendDecreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount)
    {
        $ResellerToken = $this->ResellerToken;
        $BackendUrl = $this->BackendUrl;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $params = [
            'amount' => $ChargeAmount,
            'type' => 'balance',
            'invoiceid' => 'admin',
            'status' => 'paid'
        ];

        $address = [
            $BackendUrl, 'api', 'users', $CaasifyUserId, 'transactions', 'decrease'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }
    
    public function admin_sendResellerDecreaseChargeCaasifyRequest($CaasifyUserId, $ChargeAmount)
    {
        $ResellerToken = $this->ResellerToken;
        $BackendUrl = $this->BackendUrl;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];

        $params = [
            'amount' => $ChargeAmount,
            'type' => 'balance',
            'invoiceid' => 'admin',
            'status' => 'paid'
        ];

        $address = [
            $BackendUrl, 'api', 'backend', 'users', $CaasifyUserId, 'transactions', 'decrease'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
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
