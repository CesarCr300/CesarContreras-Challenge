<?php

namespace App;
interface IBasicItem
{
    public function tick();
}

abstract class BasicItem implements IBasicItem
{
    public $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }
    public function increaseQuality($quantity = 1)
    {
        if ($this->quality < 50) {
            $this->quality += $quantity;
        }
    }
    public function decreaseQuantity($quantity = 1)
    {
        if ($this->quality > 0) {
            $this->quality -= $quantity;
        }
    }
    public function decreaseSellIn()
    {
        $this->sellIn--;
    }
}

class NormalItem extends BasicItem
{
    public function tick()
    {
        $this->decreaseSellIn();
        $this->decreaseQuantity();
        if ($this->sellIn < 0) {
            $this->decreaseQuantity();
        }
    }
}

class BasicItemFactory
{
    public static function create($name, $quality, $sellIn): BasicItem
    {
        switch ($name) {
            case 'normal':
                return new NormalItem($name, $quality, $sellIn);
            default:
                throw new \InvalidArgumentException("Unknown item type: $name");
        }
    }
}

class GildedRose
{
    public $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        $item = BasicItemFactory::create($this->name, $this->quality, $this->sellIn);
        $item->tick();
        $this->quality = $item->quality;
        $this->sellIn = $item->sellIn;
    }
}
