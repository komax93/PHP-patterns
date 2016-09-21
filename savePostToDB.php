<?php

class SavePost
{
    private $hDbConnection;
    private $sSerializeString;

    public function __construct()
    {
        $this->dbWrapper('91.209.206.77', 'mycorezp_test', 'mycorezp_max', 'T#9za58w;TDQ');
    }

    public function executeOperation()
    {
        $this->serializeStr();
        $this->addDataToTable();
    }

    private function addDataToTable()
    {
        try
        {
            $smth = $this->hDbConnection->prepare("INSERT INTO table1 (serialize_str) VALUES(:serialize_str)");
            $smth->bindParam(':serialize_str', $this->sSerializeString);
            $smth->execute();
        }
        catch(PDOException $e)
        {
            print "Query is Wrong. Mesage: " . $e->getMessage() . PHP_EOL;
        }
    }

    private function serializeStr()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $result = $_POST;
        $this->sSerializeString = json_encode($result);
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

$oSavePost = new SavePost();
$oSavePost->executeOperation();