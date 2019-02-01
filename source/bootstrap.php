<?php
define("SOURCE_DIR", __DIR__);
define("DATA_DIR", dirname(__DIR__) . '/data');
define("VENDOR_DIR", dirname(__DIR__) . '/vendor');
require VENDOR_DIR . '/autoload.php';
require_once SOURCE_DIR . '/config.php';
require_once SOURCE_DIR . '/client.php';

global $client, $service;

// Get the API client and construct the service object.
$client = client_get();
$service = new Google_Service_Classroom($client);
