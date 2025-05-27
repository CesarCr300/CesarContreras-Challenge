<?php

namespace App;
interface IBasicItem
{
    public function tick();
}

abstract class BasicItem implements IBasicItem
{

    public $quality;

    public $sellIn;

    public function __construct($quality, $sellIn)
    {
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }
    public function increaseQuality($quantity = 1)
    {
        if ($this->quality < 50) {
            $this->quality += $quantity;
        }
    }
    public function decreaseQuality($quantity = 1)
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
        $this->decreaseQuality();
        if ($this->sellIn < 0) {
            $this->decreaseQuality();
        }
    }
}

class BrieItem extends BasicItem
{
    public function tick()
    {
        $this->decreaseSellIn();
        $this->increaseQuality();
        if ($this->sellIn < 0) {
            $this->increaseQuality();
        }
    }
}

class SulfurasItem extends BasicItem
{
    public function tick()
    {
        // Sulfuras does not change, so no action needed
    }
}

class BackstagePassesItem extends BasicItem
{
    public function tick()
    {
        $this->increaseQuality();
        if ($this->sellIn < 6) {
            $this->increaseQuality(2);
        } elseif ($this->sellIn < 11) {
            $this->increaseQuality();
        }
        $this->decreaseSellIn();
        if ($this->sellIn < 0) {
            $this->quality = 0;
        }
    }
}

class ConjuredItem extends BasicItem
{
    public function tick()
    {
        $this->decreaseSellIn();
        $this->decreaseQuality(2);

        if ($this->sellIn < 0) {
            $this->decreaseQuality(2);
        }
    }
}

class BasicItemFactory
{
    public static function create($name, $quality, $sellIn): BasicItem
    {
        switch ($name) {
            case 'normal':
                return new NormalItem($quality, $sellIn);
            case 'Aged Brie':
                return new BrieItem($quality, $sellIn);
            case 'Sulfuras, Hand of Ragnaros':
                return new SulfurasItem($quality, $sellIn);
            case 'Backstage passes to a TAFKAL80ETC concert':
                return new BackstagePassesItem($quality, $sellIn);
            case 'Conjured Mana Cake':
                return new ConjuredItem($quality, $sellIn);
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
