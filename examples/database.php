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

$base = $deta->base('test');

// Example usage of the put() method
$items = [
    [
        'key' => 'item1',
        'value' => 'value1'
    ],
    [
        'key' => 'item2',
        'value' => 'value1'
    ],
    [
        'value' => date('Y-m-d H:i:s')
    ]
];
$response = $base->put($items);
print_r($response);

// Example usage of the get() method
$key = 'item1';
$response = $base->get($key);
print_r($response);

// Example usage of the delete() method
$key = 'item2';
$response = $base->delete($key);
print_r($response);

try {
    // Example usage of the insert() method
    $item = [
        'key' => 'item3',
        'value' => 'value3'
    ];
    $response = $base->insert($item);
    print_r($response);
} catch (\Throwable $th) {
    //throw $th;
}


// Example usage of the update() method
$key = 'item1';
$set = [
    'value' => date('Y-m-d H:i:s')
];
$response = $base->update($key, $set);
print_r($response);

// Example usage of the query() method
$query = [
    ['value' => 'value']
];
$limit = 10;
$response = $base->query($query, $limit);
print_r($response);