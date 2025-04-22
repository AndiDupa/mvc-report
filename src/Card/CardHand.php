<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function shuffle(): void
    {
        shuffle($this->hand);
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    public function cardToUnicode(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->cardToUnicode();
        }
        return $values;
    }

    public function getAsString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    public function wholeDeck(): void
    {
        foreach (CardGraphic::$representation as $key => $unicode) {
            $this->hand[] = new Card($key);
        }
    }

    public function cardHand(): array
    {
        return $this->hand;
    }

    public function draw(): Card
    {
        return array_shift($this->hand);
    }

    public function empty(): bool
    {
        return empty($this->hand);
    }
}
