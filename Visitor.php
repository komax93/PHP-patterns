<?php
interface Visitor
{
    public function visit(Point $point);
}

abstract class Point
{
    public abstract function accept(Visitor $visitor);
    private $_metric = -1;

    public function getMetric()
    {
        return $this->_metric;
    }

    public function setMetric($metric)
    {
        $this->_metric = $metric;
    }
}

class Point2d extends Point
{
    private $_x;
    private $_y;

    public function __construct($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visit($this);
    }

    public function getX() { return $this->_x;}
    public function getY() { return $this->_y;}
}

class Point3d extends Point
{
    private $_x;
    private $_y;
    private $_z;

    public function __construct($x, $y, $z)
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_z = $z;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visit($this);
    }

    public function getX() { return $this->_x;}
    public function getY() { return $this->_y;}
    public function getZ() { return $this->_z;}
}

class Euclid implements Visitor
{
    public function visit(Point $p)
    {
        if($p instanceof Point2d)
            $p->setMetric(sqrt($p->getX() * $p->getX() + $p->getY() * $p->getY()));
        else if($p instanceof Point3d)
            $p->setMetric(sqrt($p->getX() * $p->getX() + $p->getY() * $p->getY() + $p->getZ() * $p->getZ()));
    }
}

function start()
{
    $p = new Point2d(1, 2);
    $v = new Euclid();
    $p->accept($v);
    echo ($p->getMetric());
};

start();
