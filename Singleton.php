<?php

class Singletone
{
    private $props = array();
    private static $instance;

    private function __construct(){}

    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new Singletone();
        }
        return self::$instance;
    }

    public function setProperty($key, $val)
    {
        $this->props[$key] = $val;
    }

    public function getProperty($key)
    {
        return $this->props[$key];
    }
}

$pref = Singletone::getInstance();
$pref->setProperty("name", "Maxym");



$pref2 = Singletone::getInstance();
print $pref2->getProperty("name");