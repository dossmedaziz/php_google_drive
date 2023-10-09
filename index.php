<?php
// include autoload.php file
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/GoogleClient.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
try {
    if (!isset($argv[1])) {
        throw new Exception("File Path is missing\n");
    }
    if (!isset($argv[2])) {
        throw new Exception("Folder Id is missing\n");
    }
    $googleClient = GoogleClient::getInstance();
    $googleClient->setGoogleCredentials(__DIR__ . '/credentials.json');
    $googleClient->setFolderId($argv[2]);
    $googleClient->upload([
        'file' => $argv[1],
        'name' => basename($argv[1])
    ]);
} catch (Exception $e) {
    $error = $e->getMessage() . "\n";
    $error .= date('Y-m-d H:i:s') . "\n";
    file_put_contents(__DIR__ . '/logs/drive.log', $error, FILE_APPEND);
    exit;
}