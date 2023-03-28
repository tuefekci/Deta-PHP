<?php


// Disable SSL verification globally for cURL requests
ini_set('curl.cainfo', '');

// Enable error reporting
error_reporting(E_ALL);

// Enable displaying errors on screen
ini_set('display_errors', 1);

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR .'..');
$dotenv->load();

$deta = new \tuefekci\deta\Deta($_ENV['DETA_PROJECT_KEY'], $_ENV['DETA_API_KEY']);
//$item = array("key" => "item1", "field1" => "value1


// Create an instance of the Drive class, passing in the HTTP client instance
$drive = $deta->drive('test');

// Upload a file
$file_contents = 'This is the content of the file. '.date('Y-m-d H:i:s');
$file_name = 'example.txt';
$response = $drive->put($file_name, $file_contents);

// Check if the upload was successful
if ($response->getStatusCode() == 200) {
    echo "File uploaded successfully.\n";
} else {
    echo "File upload failed.\n";
}

// List all files
$response = $drive->list();

// Check if the request was successful
if ($response->getStatusCode() == 200) {
    $files = json_decode($response->getBody());
    echo "Files:\n";
    foreach ($files->names as $file) {
        echo "- {$file}\n";
    }
} else {
    echo "Failed to list files.\n";
}

// Download a file
$file_name = 'example.txt';
$response = $drive->get($file_name);

// Check if the download was successful
if ($response->getStatusCode() == 200) {
    $file_contents = $response->getBody();
    echo "File downloaded successfully.\n";
    echo "File contents:\n{$file_contents}\n";
} else {
    echo "File download failed.\n";
}

// Delete a file
$file_name = 'example.txt';
$response = $drive->delete([$file_name]);

// Check if the delete was successful
if ($response->getStatusCode() == 200) {
    echo "File deleted successfully.\n";
} else {
    echo "File delete failed.\n";
}