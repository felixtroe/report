<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $representation = [
    [
      "🂡", "🂢", "🂣", "🂤", "🂥", "🂦", "🂧", "🂨", "🂩", "🂪", "🂫", "🂭", "🂮",
    ],

    [
      "🂱", "🂲", "🂳", "🂴", "🂵", "🂶", "🂷", "🂸", "🂹", "🂺", "🂻", "🂽", "🂾"
    ],
    [
      "🃁", "🃂", "🃃", "🃄", "🃅", "🃆", "🃇", "🃈", "🃉", "🃊", "🃋", "🃍", "🃎",
    ],

    [
      "🃑", "🃒", "🃓", "🃔", "🃕", "🃖", "🃗", "🃘", "🃙", "🃚", "🃛", "🃝", "🃞"
    ],

    [
      "🃏","🃏"
    ]

    ];

    public function __construct(int $value, int $suit)
    {
        parent::__construct($value, $suit);
    }

    public function getAsString(): string
    {
        return $this->representation[$this->suit][$this->value - 1];
    } // måste bli en int
}
