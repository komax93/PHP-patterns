<?php

abstract class CommsManager
{
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getTtdEncoder();
    abstract function getContactEncoder();
    abstract function getFooterText();
}

class BlogsCommsManager extends CommsManager
{
    function getHeaderText()
    {
        return "BloggsCal верхний колонтитул\n";
    }

    function getApptEncoder()
    {
        return new BloggsTtdEncoder();
    }

    function getTtdEncoder()
    {
        return new BloggsTtdEncoder();
    }

    function getContactEncoder()
    {
        return new BlogsContactEncoder();
    }

    function getFooterText()
    {
        return "BloggsCal нижний колонтитул\n";
    }
}