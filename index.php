<?php
// include autoload.php file
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/GoogleClient.php';

// check if file is passed as argument
try {
    if (!isset($argv[1])) {
        throw new Exception("File Path is missing\n");
    }
    $googleClient = GoogleClient::getInstance();
    $googleClient->setGoogleCredentials(__DIR__ . '/src/config/credentials.json');
    $googleClient->setFolderId("1CAkn_Wc8CjTuGrSMoKd2Nsaj1l-5kvgQ");
    $googleClient->upload([
        'file' => $argv[1],
        'name' => basename($argv[1])
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}