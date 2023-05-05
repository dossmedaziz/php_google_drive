<?php
// include autoload.php file
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/GoogleClient.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// check if file is passed as argument
try {
    if (!isset($argv[1])) {
        throw new Exception("File Path is missing\n");
    }
    $googleClient = GoogleClient::getInstance();
    $googleClient->setGoogleCredentials(__DIR__ . '/credentials.json');
    $googleClient->setFolderId($_ENV['FOLDER_ID']);
    $googleClient->upload([
        'file' => $argv[1],
        'name' => basename($argv[1])
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}