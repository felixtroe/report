<?php

namespace App\Card;

class Card
{
    protected $value;
    protected $suit;
    public function __construct(int $value, int $suit)
    {
        $this->value = $value;
        $this->suit  = $suit;

    }
    public function getValue(): int
    {
        return $this->value;
    }

    public function getSuit(): string
    {
        $suits = ["spade","heart","diamond","club"];
        return $suits[$this->suit];
    }


    public function getString(): string
    {
        return "[{$this->value} {$this->getSuit()}]";
    }


}
