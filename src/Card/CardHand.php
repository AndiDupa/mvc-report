<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var Card[] $hand holds Card
     */
    private array $hand = [];

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

    /**
     * @return string[] $values cards as unicode
     */
    public function cardToUnicode(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->cardToUnicode();
        }
        return $values;
    }

    /**
     * @return string[] $values cards as strings
     */
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
        foreach (array_keys(CardGraphic::$representation) as $key) {
            $this->hand[] = new Card($key);
        }
    }

    /**
     * @return Card[] $this->hand returns whole hand
     */
    public function cardHand(): array
    {
        return $this->hand;
    }

    /**
     * @return Card|null Card or null if deck empty
     */
    public function draw(): ?Card
    {
        return array_shift($this->hand);
    }

    public function empty(): bool
    {
        return empty($this->hand);
    }
}
