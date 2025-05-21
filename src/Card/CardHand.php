<?php

namespace App\Card;

class CardHand
{
    private $hand = [];

    public function add($card): void
    {
        $this->hand[] = $card;
    }

    public function getNumberCard(): int
    {
        return count($this->hand);
    }

    public function getHand(): array
    {
        return $this->hand;
    }


    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = [
             "card" => $card->getAsString(),
             "suit" => $card->getSuit()
            ];
        }

        return $values;
    }
}
