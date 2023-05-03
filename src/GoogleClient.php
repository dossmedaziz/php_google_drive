<?php
//require_once '../vendor/autoload.php';

use Google\Client as Google_Client;

class GoogleClient
{

    private static $instance;
    private $folderId;
    private $googleCredentials;

    private function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new GoogleClient();
        }
        return self::$instance;
    }

    public function setGoogleCredentials($googleCredentials)
    {
        $this->googleCredentials = $googleCredentials;
    }

    public function setFolderId($folderId)
    {
        $this->folderId = $folderId;
    }

    public function upload(array $data)
    {
        $client = new Google_Client();
        $client->setAuthConfig($this->googleCredentials);
        $client->addScope(Google_Service_Drive::DRIVE_FILE);

        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $data['name'],
            'parents' => array($this->folderId)
        ));

        $content = file_get_contents($data['file']);
        $mimeType = mime_content_type($data['file']);
        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'resumable'
        ));
    }
}