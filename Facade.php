<?php
class ProductFacade
{
    private $products = array();

    function __construct($file)
    {
        $this->file = $file;
        $this->compile();
    }

    private function compile()
    {
        $lines = getProductFileLines($this->file);
        foreach($lines as $line)
        {
            $id = getIdFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromID($id, $name);
        }
    }

    function getProducts()
    {
        return $this->products;
    }

    function getProduct($id)
    {
        if(isset($this->products[$id]))
        {
            return $this->products[$id];
        }
        return null;
    }
}

$facade = new ProductFacade('test.txt');
$facade->getProduct(234);