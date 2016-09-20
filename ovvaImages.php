<?php

class HashImages{
    private $hDbConnection;
    private $iCountOfImages = 0;
    private $iCountOfCorrectImages = 0;
    private $iCountOfWrongImages = 0;

    public function __construct()
    {
        $this->dbWrapper('localhost', 'ovva', 'root', '123qweASD');
    }

    public function executeOperation()
    {
        $this->chooseImageLink();
        echo "All images: " . $this->iCountOfImages . PHP_EOL .
             "Error images: " . $this->iCountOfWrongImages . PHP_EOL .
             "Correct images: " . $this->iCountOfCorrectImages . PHP_EOL;
    }

    private function chooseImageLink()
    {
        try
        {
            $sth = $this->hDbConnection->prepare("SELECT image_hash, image_type FROM image2_meta");
            $sth->execute();

            while($row = $sth->fetch())
            {
                $url = $this->getImageUrl($row['image_hash'], $row['image_type']);
                $response = (int) $this->getHttpResponse($url);

                if($response < 400)
                {
                    $this->iCountOfCorrectImages++;
                }
                elseif ($response >= 400)
                {
                    $this->iCountOfWrongImages++;
                }

                $this->iCountOfImages++;
                if($this->iCountOfImages >= 10000)
                {
                    break;
                }
            }

        }
        catch (PDOException $e)
        {
            print "Error: " . $e->getMessage() . PHP_EOL;
        }
    }

    private function getHttpResponse($sURL)
    {
        $aCurlInfo = array();
        $hCurl = curl_init();
        curl_setopt($hCurl, CURLOPT_URL, $sURL);
        curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($hCurl, CURLOPT_HEADER, 0);

        $sHtmlContent = curl_exec($hCurl);
        if($sHtmlContent === false)
        {
            return;
        }
        curl_exec($hCurl);

        $aCurlInfo = curl_getinfo($hCurl);
        $response =  $aCurlInfo['http_code'];
        curl_close($hCurl);

        return $response;
    }

    private function getImageUrl($sHash, $sType)
    {
        $sType = image_type_to_extension($sType);
        $sP1 = substr($sHash, 0, 3);
        $sP2 = substr($sHash, 3, 3);
        $sP3 = substr($sHash, 6, 3);

        return "https://images.ovva.tv/media/images/{$sP1}/{$sP2}/{$sP3}/" . $sHash . $sType;
    }

    private function dbWrapper($host, $dbName, $user, $password)
    {
        try
        {
            $this->hDbConnection = new PDO("mysql:host=$host; dbname=$dbName", $user, $password, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->hDbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->hDbConnection->exec("SET NAMES utf8");
        }
        catch (PDOException $e)
        {
            print "Connection is wrong. Message: " . $e->getMessage() . PHP_EOL;
        }
    }
}

$oHashImages = new HashImages();
$oHashImages->executeOperation();