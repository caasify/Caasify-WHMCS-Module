<?php

use WHMCS\Database\Capsule;

require('init.php');

$admin = caasify_get_session('adminid');

if (!$admin) {
    exit('You are not admin.');
}

class CaasifyController
{
    const UPDATE_URL = 'https://update.caasify.com';

    public function settings()
    {
        $systemUrl = Capsule::table('tblconfiguration')->where('setting', 'SystemURL')->first();

        if (!$systemUrl) {
            return $this->jsonMessage('Could not find system URL.');
        }

        return $this->jsonResponse([
            'systemUrl' => $systemUrl->value
        ]);
    }

    public function permission()
    {
        $path = $this->createLocalPath();

        $directory = new RecursiveDirectoryIterator($path, 
            RecursiveDirectoryIterator::SKIP_DOTS);

        $iterator = new RecursiveIteratorIterator($directory, 
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $item) {

            $item->isDir() ? chmod($item, 0755) : chmod($item, 0644);
        }

        return $this->jsonMessage('Permission has been updated.');
    }

    public function update()
    {
        // Send HTTP GET Request to download zip file
        $url = $this->createURL(['whmcs', 'downloadedcaasify.zip']);

        $response = $this->sendRequest($url);

        if (!$response) {
            return $this->jsonMessage('Could not download update.');
        }

        // Save downloaded zip file to local file
        $file = $this->createLocalPath('update.zip');

        $success = $this->writeToFile($file, $response);

        if (!$success) {
            return $this->jsonMessage('Could not write to file.');
        }

        // Initialize it to handle zip operations
        $zip = new ZipArchive();

        // Attempt to open zip file
        $success = $zip->open($file);

        if (!$success) {
            return $this->jsonMessage('Could not open file.');
        }

        // Extract all files from zip to local directory
        $extractPath = $this->createLocalPath();

        $zip->extractTo($extractPath);

        // Read marketplace file
        $marketplaceFile = $zip->getFromName('templates/twenty-one/vpspricing.tpl');
        
        // Copy marketplace file to all templates
        $templatesPath = $this->createLocalPath('templates/*');
        
        $folders = glob($templatesPath, GLOB_ONLYDIR);

        foreach ($folders as $folder) {

            $folderName = basename($folder);

            $folderPath = $this->createLocalPath("templates/{$folderName}/vpspricing.tpl");

            @file_put_contents($folderPath, $marketplaceFile);
        }

        $zip->close();

        // Update was successful
        return $this->jsonMessage('The module has been updated.');
    }

    public function writeToFile($file, $content)
    {
        return file_put_contents($file, $content);
    }

    public function createLocalPath($name = null)
    {
        $currentDirectory = dirname(__FILE__);

        if ($name) {
            return implode('/', [$currentDirectory, $name]);
        }

        return $currentDirectory;
    }

    public function gifts()
    {
        $gifts = Capsule::table('tblcaasify_gifts')->get();

        return $this->jsonResponse(['data' => $gifts]);
    }

    public function createGift()
    {
        $params = json_decode(
            file_get_contents('php://input'), true);

        $name = caasify_get_array('name', $params);

        if (empty($name)) {
            return $this->jsonMessage('The name field is required');
        }

        $code = caasify_get_array('code', $params);

        if (empty($code)) {
            return $this->jsonMessage('The code field is required');
        }
        
        $percent = caasify_get_array('percent', $params);
        
        if (empty($percent)) {
            return $this->jsonMessage('The percent field is required');
        }
        
        $total = caasify_get_array('total', $params);
        
        if (empty($total)) {
            return $this->jsonMessage('The total field is required');
        }

        if (!is_numeric($total)) {
            return $this->jsonMessage('The total field must be a number');
        }

        if (!is_numeric($percent)) {
            return $this->jsonMessage('The percent field must be a number');
        }

        $params = [
            'name' => $name, 'code' => $code, 'percent' => $percent, 'total' => $total
        ];

        Capsule::table('tblcaasify_gifts')
            ->insert($params);

        $gift = Capsule::table('tblcaasify_gifts')
            ->where('code', $code)->first();

        return $this->jsonResponse(['data' => $gift]);
    }

    public function deleteGift()
    {
        $params = json_decode(
            file_get_contents('php://input'), true);

        $id = caasify_get_array('id', $params);

        if (empty($id)) {
            return $this->jsonMessage('The id field is required');
        }

        $gift = Capsule::table('tblcaasify_gifts')
            ->where('id', $id)->first();

        if (!$gift) {
            return $this->jsonMessage('The gift not found');
        }

        Capsule::table('tblcaasify_gifts')
            ->where('id', $id)->delete();

        return $this->jsonResponse(['data' => $gift]);
    }

    public function invoices()
    {
        $invoices = Capsule::select('SELECT c.firstname, c.lastname, a.id, a.ratio, a.chargeamount, a.real_charge_amount, a.commission, a.transactionid, b.id as invoice_id, b.status as invoice_status, y.percent as gift_percent FROM tblcaasify_invoices a INNER JOIN tblinvoices b ON b.id = a.invoiceid INNER JOIN tblclients c ON c.id = a.whuserid LEFT JOIN tblcaasify_gift_invoice x ON x.invoice_id = a.invoiceid LEFT JOIN tblcaasify_gifts y ON y.id = x.gift_id ORDER BY a.id DESC LIMIT 100');

        return $this->jsonResponse(['data' => $invoices]);
    }

    public function latestVersion()
    {
        $version = $this->getLatestVersion();

        if (!$version) {
            return $this->jsonMessage('Could not found version.');
        }

        return $this->jsonResponse(['version' => $version]);
    }

    public function getLatestVersion()
    {
        $url = $this->createURL(['whmcs', 'caasifyversion.txt']);

        $response = $this->sendRequest($url);

        return $response;
    }

    public function sendRequest($url)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl, CURLOPT_USERAGENT, 'Caasify');

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function jsonMessage($message)
    {
        return $this->jsonResponse([
            'message' => $message
        ]);
    }

    public function jsonResponse($data)
    {
        header('Content-Type: application/json');

        echo json_encode($data);
    }

    public function createURL($segments)
    {
        array_unshift($segments, static::UPDATE_URL);

        return implode('/', $segments);
    }

    public function localVersion()
    {
        $version = $this->getLocalVersion();

        if (!$version) {
            return $this->jsonMessage('Could not found version.');
        }

        return $this->jsonResponse(['version' => $version]);
    }

    public function getLocalVersion()
    {
        $version = $this->readFile('caasifyversion.txt');

        return $version;
    }

    public function readFile($file)
    {
        $path = dirname(__FILE__) . '/' . $file;

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        throw new Exception('Could not find file');
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

$action = caasify_get_query('action');

$controller = new CaasifyController();
$controller->handle($action);
