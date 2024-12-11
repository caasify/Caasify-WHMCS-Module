<?php
use PG\Request\Request;
use WHMCS\Database\Capsule;

class AdminCaasifyoutputController
{    
    
    public function __construct(){
        // die('from controller');

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

    public function admin_addPromotionCode(){
        $this->addPromotionCode(false);
    }
    public function admin_editPromotionCode(){
        $this->addPromotionCode(true);
    }

    private function addPromotionCode($edit)
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        if($edit == true){

            $id = $requestData['id'];
            $promotionQuery = Capsule::table("tblcaasify_promotions")->where("id", $id);

            if(!$promotionQuery->exists()){
                $this->response([
                    "status" => false,
                    "msg" => "Promotion not found"
                ]);
            }
        }

        $inputs = [
            "code" => $requestData["promotion_code"],
            "type" => $requestData["type"],
            "value" => $requestData["value"],
            "start_date" => $requestData["start_date"],
            "expiration_date" => $requestData["expiration_date"],
            "max_use" => $requestData["max_use"],
            "recurring_no" => $requestData["recurring_no"],
            "user_type" => $requestData["user_type"],
            "min_amount" => $requestData["min_amount"],
            "max_amount" => $requestData["max_amount"],
        ];

        $optionalInputs = [
            "user_list" => $requestData["user_list"]
        ];

        if(in_array("" , $inputs)){
            $this->response([
                "status" => false,
                "msg" => "Please fill all required fields"
            ]);
        }
        else {
            if($edit)
                $validation = $this->promotionValidation($inputs , $optionalInputs , $promotionQuery);
            else
                $validation = $this->promotionValidation($inputs , $optionalInputs);

            if(!$validation[0]){
                $this->response([
                    "status" => false,
                    "msg" => $validation[1]
                ]);
            }else{

                $inputs["conditions"] = serialize([
                    "min_amount" => $inputs["min_amount"],
                    "max_amount" => $inputs["max_amount"],
                ]);

                unset($inputs["min_amount"]);
                unset($inputs["max_amount"]);

                if($inputs["user_type"] == "specific_users"){
                    $inputs["user_list"] = serialize( $optionalInputs["user_list"] );
                }


                try{
                    if($edit)
                    {
                        $promotionQuery->update($inputs);
                        $this->response([
                            "status" => true,
                            "msg" => "Promotion code edited successfully"
                        ]);
                    }
                    else {
                        Capsule::table("tblcaasify_promotions")->insert($inputs);
                        $this->response([
                            "status" => true,
                            "msg" => "Promotion code added successfully"
                        ]);
                    }

                }catch (Exception $e){
                    $this->response([
                        "status" => true,
                        "msg" => "Unhandled exception " . $e->getMessage()
                    ]);
                }
            }
        }

    }

    public function deactivatePromotionCode(){
        $requestData = json_decode(file_get_contents("php://input"), true);
        $id = intval($requestData["id"]);

        Capsule::table('tblcaasify_promotions')->where('id', $id)->update([
            "status" => false
        ]);
        $this->response([
            "status" => true,
            "msg" => "Promotion code successfully deactivated"
        ]);
    }
    public function activatePromotionCode(){
        $requestData = json_decode(file_get_contents("php://input"), true);
        $id = intval($requestData["id"]);

        Capsule::table('tblcaasify_promotions')->where('id', $id)->update([
            "status" => true
        ]);

        $this->response([
            "status" => true,
            "msg" => "Promotion code activated successfully"
        ]);
    }

    public function getAllowedUserList()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        $promotionId = intval($requestData["id"]);

        $promotion = Capsule::table('tblcaasify_promotions')->where('id', $promotionId);

        $result = [];

        if($promotion->exists()){
            $promotion = $promotion->first();


            $userList = unserialize($promotion->user_list);

            foreach($userList as $userId){
                $user = $this->getUserDetail($userId);
                if($user != null){

                    $result[] = [
                        "name" => $user->first_name . " " . $user->last_name,
                        "count" => $this->getPromotionUsedNo($user->id , $promotionId)
                    ];

                }
            }

            $this->response( [
                "status" => true,
                "data" => $result,
                "message" => "success"
            ]);
        }
        else {
            $this->response( [
                "status" => false,
                "data" => null,
                "message" => "Promotion not found"
            ]);
        }
    }

    public function getUsedDetail()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        $promotionId = intval($requestData["id"]);

        $promotion = Capsule::table('tblcaasify_promotions_used')->where('promotion_id', $promotionId);

        $result = [];

        if($promotion->exists()){
            $promotion = $promotion->get();

            foreach ($promotion as $row) {

                $user = $this->getUserDetail($row->user_id);
                if($user != null){

                    $result[] = [
                        "name" => $user->first_name . " " . $user->last_name,
                        "count" => $this->getPromotionUsedNo($user->id , $row->promotion_id)
                    ];

                }
            }

            $this->response( [
                "status" => true,
                "data" => $result,
                "message" => "success"
            ]);
        }
        else {
            $this->response( [
                "status" => false,
                "data" => [],
                "message" => "Not used yet"
            ]);
        }
    }


    private function promotionValidation($inputs , $optionalInputs , $update = null){
        $checkIfExistsQuery = Capsule::table("tblcaasify_promotions")->where('code' , $inputs["code"]);

        if($update != null){
            $promotionDetail = $update->first();
            if($promotionDetail != null && $promotionDetail->code != $inputs["code"]){

                if($checkIfExistsQuery->exists()){
                    return [false , "Promotion code must be unique" ];
                }
            }
        }
        else if($checkIfExistsQuery->exists()){
            return [false , "Promotion code must be unique" ];
        }

        if(strlen($inputs["code"]) < 9)
        {
            return [false , "Promotion code length must be at least 9" ];
        }
        else if(!is_numeric($inputs["value"])){
            return [false , "Promotion value must be numeric" ];
        }
        else if ($inputs["type"] == "percent" and ($inputs["value"] < 1 || $inputs["value"] > 100)){
            return [false , "Promotion value must be between 0 and 100 in percent type" ];
        }
        else if ($inputs["type"] == "fixed" and $inputs["value"] < 1){
            return [false , "Promotion value must be greater than zero" ];
        }
        else if($inputs["expiration_date"] < $inputs["start_date"]){
            return [false , "End date must be greater than start date" ];
        }
        else if (!is_numeric($inputs["max_use"]) || $inputs["max_use"] < 0){
            return [false , "Max use is not valid" ];
        }
        else if (!is_numeric($inputs["recurring_no"]) || $inputs["recurring_no"] < 1){
            return [false , "Recurring no is not valid" ];
        }
        else if($inputs["user_type"] != "all_users" and $inputs["user_type"] != "new_users" and $inputs["user_type"] != "specific_users"){
            return [false , "User type is not valid" ];
        }
        else if( $inputs["min_amount"] < 0){
            return [false , "Minimum amount cannot be less than zero" ];
        }
        else if( $inputs["max_amount"] < 0){
            return [false , "Maximum amount cannot be less than zero" ];
        }
        else if ($inputs["min_amount"] > $inputs["max_amount"]) {
            return [false , "Minimum amount cannot be less than Maximum amount" ];
        }
        else{
            if($inputs["user_type"] == "specific_users"){
                try{
                    $userList = $optionalInputs["user_list"];
                    if(count($userList) < 1){
                        return [false , "User list cannot be empty" ];
                    }
                }catch (Exception $e){
                    return [false , "Something went wrong!" ];
                }
            }
            return [true , "Successful" ];
        }
    }

    private function getUserDetail($id){
        $query = Capsule::table('tblusers')->where('id', $id);
        if($query->exists()){
            return $query->first();
        }
        else{
            return null;
        }
    }

    private function getPromotionUsedNo($userId , $promotionId){
        $query = Capsule::table('tblcaasify_promotions_used')->where('user_id', $userId)->where('promotion_id', $promotionId);
        return $query->count();
    }

    public function getPromotionDetail(){
        $requestData = json_decode(file_get_contents("php://input"), true);
        $promotionId = intval($requestData["id"]);

        $query = Capsule::table("tblcaasify_promotions")->where('id' , $promotionId);
        if($query->exists()){
            $promotion = $query->first();
            $conditions = unserialize($promotion->conditions);

            $promotion->min_amount = $conditions["min_amount"];
            $promotion->max_amount = $conditions["max_amount"];

            unset($promotion->conditions);

            if($promotion->user_list != null){
                $promotion->user_list = unserialize($promotion->user_list);
            }

            $this->response([
                "status" => true,
                "data" => $promotion,
                "message" => "success"
            ]);
        }
        else {
            $this->response([
                "status" => false,
                "data" => [],
                "message" => "Promotion not found"
            ]);
        }
    }

}