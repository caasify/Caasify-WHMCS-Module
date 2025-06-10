<?php
require_once('../../config.php');
$token = caasify_get_reseller_token();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $origin = $_POST['origin'];
    
    switch ($action) {
        case 'loadConfigForVPSPricing':
            if($origin){
                loadConfigForVPSPricing();
            } else {
                die('request is not valid');
            }
            break;
        case 'loadFilterTerms':
            if($origin){
                $url = "https://api.caasify.com/api/common/terms";
                loadFilterTerms($url, $token);
            } else {
                die('request is not valid');
            }
            break;
        case 'GetPlansFromFiltersTerm':
            $formData = $_POST;
            $url = "https://api.caasify.com/api/candy/common/products"; 
            GetPlansFromFiltersTerm($url, $token, $formData);
            break;
        case 'GetVPNPlans':
            $url = "https://api.caasify.com/api/candy/common/products?type=vpn"; 
            GetPlansList($url, $token);
            break;
        case 'GetHostPlans':
            $url = "https://api.caasify.com/api/candy/common/products?type=host"; 
            GetPlansList($url, $token);
            break;
        case 'GetRecomPlansForContinent':
            $formData = $_POST;
            $url = "https://api.caasify.com/api/candy/common/suggestion"; 
            GetRecomPlansForContinent($url, $token, $formData);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
            exit;
    }
}

function loadFilterTerms($url, $token){
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token"
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    echo $response;
} 


function GetPlansList($url, $token){
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token"
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    echo $response;
} 

function loadConfigForVPSPricing(){
    $calc = caasify_calculate_ratio_for_vpspricing();
    if(isset($calc['ratio']) && isset($calc['currency'])){
        $response = [
            'data' => [ 
                'ratio' => $calc['ratio'],
                'currency' => $calc['currency'],
            ],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} 

function GetPlansFromFiltersTerm($url, $token, $formData) {
    if (empty($formData)) {
        die('request is not valid');
    }
    
    // header to define JSON and allow cross-origin requests
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    // Prepare query parameters
    $queryParams = [];

    // Loop through 'term' in formData
    foreach ($formData['term'] as $key => $values) {
        // Append each value as term[key][]
        foreach ($values as $value) {
            $queryParams[] = "term[$key][]=" . urlencode($value);
        }
    }

    // Convert the query parameters array into a string
    $queryString = implode('&', $queryParams);

    // Append the query string to the URL
    $url = rtrim($url, '/') . '/?' . $queryString;

    // Initialize cURL and make the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token"
    ]);

    // Execute the cURL request and handle errors
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    if (strpos($response, 'Not Found') !== false || $http_code === 404 || empty($response)) {
        echo json_encode(['message' => 'There is nothing']);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    echo $response;
}

function GetRecomPlansForContinent($url, $token, $formData) {
    if (empty($formData)) {
        die('request is not valid');
    }
    // header to define JSON and allow cross-origin requests
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    // Initialize cURL
    $ch = curl_init();

    // Convert the form data to JSON format for POST request
    $postData = json_encode($formData);
    
    // Set cURL options for POST request
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);  // Use POST method
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  // Send the data as JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"  // Specify JSON content type
    ]);

    // Execute the cURL request and handle errors
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    // Check for 404 or empty responses
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (strpos($response, 'Not Found') !== false || $http_code === 404 || empty($response)) {
        echo json_encode(['message' => 'There is nothing']);
        curl_close($ch);
        exit;
    }
    
    // Close cURL session
    curl_close($ch);
    
    // Return the response
    echo $response;
}

?>
