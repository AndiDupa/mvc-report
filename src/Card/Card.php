<?php

namespace App\Card;

class Card
{
    public string $value;

    public function __construct(string $value = "")
    {
        $this->value = $value;
    }

    public function cardToUnicode(): string
    {
        return CardGraphic::$representation[$this->value];
    }

    public function getAsString(): string
    {
        return "{$this->value}";
    }

    public function cardColorClass(): string
    {
        return CardGraphic::cardColor($this->value);
    }
}
