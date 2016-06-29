<?php

class Singleton
{
    private $props = array();
    private static $instance;

    private function __construct(){}

    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new Singleton();
        }

        return self::$instance;
    }

    public function setProperty($key, $value)
    {
        $this->props[$key] = $value;
    }

    public function getPropery($key)
    {
        return $this->props[$key];
    }
}

$pref = Singleton::getInstance();
$pref->setProperty("key", 1);

$pref2 = Singleton::getInstance();
print $pref2->getPropery(key);