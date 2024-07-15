<?php
require_once('./config.php');
$MyCaasifyStatus = caasify_get_mycaasify_status();

if(isset($configs)){
    if(!isset($MyCaasifyStatus) || $MyCaasifyStatus != 'on'){
        $extraData = [ 'MyCaasifyStatus' => 'off' ];
    } else {
        $extraData = [ 'MyCaasifyStatus' => 'on' ];
    }

    $ConfigData = array_merge($configs, $extraData);
    
    header('Content-Type: application/json');
    echo json_encode(['configs' => $ConfigData]);
} else {
    echo json_encode(['message' => 'can not find configs form configApi']);
}
?>