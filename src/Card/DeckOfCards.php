<?php

namespace App\Card;

class DeckOfCards
{
    private $deckOfCards = [];

    public function __construct()
    {
        $this->init();
    }


    private function init(): void
    {
        for ($suit = 0; $suit < 4; $suit++) {
            for ($value = 1 ;$value < 14; $value++) {
                $card = new CardGraphic($value, $suit);
                $this->deckOfCards[] = $card;
            }
        }
    }


    public function getNumberCard(): int
    {
        return count($this->deckOfCards);
    }

    public function getDeckOfCards(): array
    {
        return $this->deckOfCards;
    }

    public function shuffle(): void
    {

        for ($index = 0; $index < count($this->deckOfCards); $index++) {
            $tmp = $this->deckOfCards[$index];
            $random = random_int(0, count($this->deckOfCards) - 1);
            $this->deckOfCards[$index] = $this->deckOfCards[$random];
            $this->deckOfCards[$random] = $tmp;
        }

    }

    public function draw(): CardGraphic
    {
        $random = random_int(0, count($this->deckOfCards) - 1);
        $card = $this -> deckOfCards[$random];
        unset($this->deckOfCards[$random]);
        $this->deckOfCards = array_values($this->deckOfCards);
        return $card;
    }


    public function getString(): array
    {
        $values = [];
        foreach ($this->deckOfCards as $card) {
            $values[] = [
             "card" => $card->getAsString(),
             "suit" => $card->getSuit()
            ];
        }
        return $values;
    }


}
