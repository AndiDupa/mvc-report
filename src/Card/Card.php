<?php

/**
 * This is the Card Class
 * The Card class holds methods for creating Card objects
 */

namespace App\Card;

use App\Card\CardHand;

class Card
{
    /**
     * @var string $value Is string value of the card object
    */
    public string $value;

    public function __construct(string $value = "")
    {
        $this->value = $value;
    }

    /**
     * @return string $graphic Returns the unicode equivalent of the card abbreviation
     */
    public function cardToUnicode(): string
    {
        $graphic = new CardGraphic();
        return $graphic->cardUnicode($this->value);
    }

    /**
     * @return string $value Returns the string value of the Card object
     */
    public function getAsString(): string
    {
        return "{$this->value}";
    }

    /**
     * @return string $graphic Return the color class of the Card object type
     */
    public function cardColorClass(): string
    {
        $graphic = new CardGraphic();
        return $graphic->cardColor($this->value);
    }
}
