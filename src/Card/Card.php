<?php

namespace App\Card;

use App\Card\CardHand;

class Card
{
    public string $value;

    public function __construct(string $value = "")
    {
        $this->value = $value;
    }

    public function cardToUnicode(): string
    {
        $graphic = new CardGraphic();
        return $graphic->cardUnicode($this->value);
    }

    public function getAsString(): string
    {
        return "{$this->value}";
    }

    public function cardColorClass(): string
    {
        $graphic = new CardGraphic();
        return $graphic->cardColor($this->value);
    }
}
