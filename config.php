<?php

// Usage:
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$path = __DIR__ . '/credential.json';
$client->setAuthConfig($path);

$service = new Google_Service_Sheets($client);

