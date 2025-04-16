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

    public static function wholeDeck(): array
    {
        $deck = [];

        foreach (CardGraphic::$representation as $key => $unicode) {
            $deck[] = new Card($key);
        }

        return $deck;
    }

    public static function shuffleDeck(): array
    {
        $deck = Card::wholeDeck();

        shuffle($deck);

        return $deck;
    }

    // public function roll(): int
    // {
    //     $this->value = random_int(1, 52);
    //     return $this->value;
    // }

    // public function getValue(): int
    // {
    //     return $this->value;
    // }

    public function getAsString(): string
    {
        return "{$this->value}";
    }
}
