<?php
// test parts
// $permissions = fileperms('caasifyupdatefunc.php');
// echo substr(decoct($permissions), -3);


// Kill if not admin
define('ROOTDIR', dirname(__FILE__));
require_once(ROOTDIR . '/init.php');

$admin = $_SESSION['adminid'];
if(empty($admin)){
    header('Location: /index.php');
    exit(); 
}


$maxDepth = 12;
$DirectoriesList = [
                    'caasifyupdater',
                    'modules/addons/caasify', 
                    'caasifyupdatefunc.php', 
                    'caasifyupdatepage.php', 
                    'caasifyversion.txt',
                ];
                

$RemoteZipAddress = 'https://update.caasify.com/whmcs/downloadedcaasify.zip';
$RemoteVersionAddress = 'https://update.caasify.com/whmcs/caasifyversion.txt';
$RemoteVersion = file_get_contents($RemoteVersionAddress);
if(empty($RemoteVersion)){$RemoteVersion = 0;}

$localZipAddress = __DIR__ . '/downloadedcaasify.zip';
$RooteAddress = __DIR__ . '/';
$LocalVersionAddress = __DIR__ . '/caasifyversion.txt';
$LocalVersion = file_get_contents($LocalVersionAddress);

if(empty($LocalVersion)){$LocalVersion = 0;}


// Read Method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (isset($requestData['funcmethod'])) {
        $method = $requestData['funcmethod'];
    }
}


// Check Method
if(empty($method) || ($method != 'install' && $method != 'download' &&  $method != 'delete' && $method != 'update' && $method != 'fix' && $method != 'hardDelete')){
    $method = 'none';
}

if($method == 'none'){
    return;
}


if($method == 'download')
{
    DownloadZip($RemoteZipAddress, $localZipAddress);
}

if($method == 'install' || $method == 'update')
{
    DownloadZip($RemoteZipAddress, $localZipAddress);
    ExtractZip($localZipAddress, $RooteAddress);
    DeletDirectory('__MACOSX');
    DeletDirectory('downloadedcaasify.zip');
    foreach ($DirectoriesList as $item) {
        setPermissions($item, $maxDepth);
    }
}

if($method == 'fix')
{    
    foreach ($DirectoriesList as $item) {
        setPermissions($item, $maxDepth);
    }
}

if($method == 'delete')
{    
    foreach ($DirectoriesList as $item){
        if($item != 'modules/addons/caasify' && $item != 'caasifyupdatepage.php' && $item != 'caasifyupdatefunc.php' && $item != 'caasifyversion.txt' && $item != 'caasifyupdater'){
            DeletDirectory($item);
        }
    }
}

if($method == 'hardDelete')
{    
    foreach ($DirectoriesList as $item){
        DeletDirectory($item);
    }
}




function DeletDirectory($src) {
    $notexist = '<span class="text-danger">Not Exist: </span>';

    if (!file_exists($src)) {
        echo $notexist;
        echo $src . '<br>';
        return;
    }

    if (is_file($src)) {
        unlink($src);
        echo "Deleted : $src <br>";
        return;
    }
    
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if (is_dir($full) ) {
                DeletDirectory($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    if (is_dir($src) && rmdir($src)) {
        echo "Deleted : $src <br>";
    } elseif (is_file($src) && unlink($src)) {
        echo "Deleted : $src <br>";
    } else {
        echo "Error: $src <br>";
    }
    
}





function DownloadZip($RemoteZipAddress, $localZipAddress) 
{
    
    // Initialize cURL session
    $ch = curl_init($RemoteZipAddress);
    $fp = fopen($localZipAddress, 'wb');

    // Set cURL options
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Execute cURL session
    curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Zip file downloaded successfully.<br>';
    }

    // Close cURL session and file pointer
    curl_close($ch);
    fclose($fp);
}






function ExtractZip($localZipAddress, $RooteAddress) 
{   
    // Check if the zip file was downloaded successfully
    if (file_exists($localZipAddress)) {
        // Open the zip file
        $zip = new ZipArchive;
        if ($zip->open($localZipAddress) === TRUE) {
            // Extract the contents to the local directory
            $zip->extractTo($RooteAddress);
            $zip->close();
            echo 'Zip file extracted successfully.<br>';
        } else {
            echo 'Failed to open the zip file.<br>';
        }
    } else {
        echo 'Failed to download the zip file.<br>';
    }
}






function setPermissions($path, $maxDepth = 12, $currentDepth = 0) {
    if ($currentDepth > $maxDepth) {
        return; // Stop recursion if maximum depth is reached
    }

    if (is_dir($path)) {
        // Set permissions for folders to 755
        chmod($path, 0755);
        echo('0755 : ' . $path . '<br>');

        // Get all items in the folder
        $items = glob($path . '/*');
        
        // Set permissions recursively for each item
        foreach ($items as $item) {
            setPermissions($item, $maxDepth, $currentDepth + 1);
        }
    } elseif (is_file($path)) {
        // Set permissions for files to 644
        chmod($path, 0644);
        echo('0644 : ' . $path . '<br>');
    }
}



?>
