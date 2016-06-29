<?php

abstract class ApptEncoder
{
    abstract function encode();
}

class BlogsApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Data encoded in BloggsCal format " . PHP_EOL;
    }
}

abstract class CommsManager
{
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager
{
    function getHeaderText()
    {
        return "BloggsCal верхний колонтитул" . PHP_EOL;
    }

    function getApptEncoder()
    {
        return new BlogsApptEncoder();
    }

    function getFooterText()
    {
        return "BloggsCal нижний колонтитул" . PHP_EOL;
    }
}

$mgr = new BloggsCommsManager();
print $mgr->getHeaderText();
print $mgr->getApptEncoder()->encode();
print $mgr->getFooterText();