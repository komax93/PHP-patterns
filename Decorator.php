<?php
abstract class Tile
{
    abstract function getWeathFactor();
}

class Plains extends Tile
{
    private $wealthfactor = 2;

    function getWeathFactor()
    {
        return $this->wealthfactor;
    }
}

abstract class TileDecorator extends Tile
{
    protected $tile;

    function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator
{
    function getWeathFactor()
    {
        return $this->tile->getWeathFactor() + 2;
    }
}

class PollutionDecorator extends TileDecorator
{
    function getWeathFactor()
    {
        return $this->tile->getWeathFactor() - 4;
    }
}