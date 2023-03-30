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

// Create an instance of the Drive class
$drive = $deta->drive('test');

// Upload a file
$file_contents = 'This is the content of the file. '.date('Y-m-d H:i:s');
$file_name = 'example.txt';
$response = $drive->put($file_name, $file_contents);
var_dump($response);

// List all files
$files = $drive->list();
echo "Files:\n";
foreach ($files->names as $file) {
	echo "- {$file}\n";
}


// Download a file
try {
	$file_name = 'example.txt';
	$file_contents = $drive->get($file_name);

    echo "File downloaded successfully.\n";
    echo "File contents:\n{$file_contents}\n";
} catch (\Throwable $th) {
    echo "File download failed.\n";
}


// Delete a file
try {
	$file_name = 'example.txt';
	$response = $drive->delete($file_name); // alternative also accepts array of file names

    echo "File deleted successfully.\n";
} catch (\Throwable $th) {
    echo "File delete failed.\n";
}
