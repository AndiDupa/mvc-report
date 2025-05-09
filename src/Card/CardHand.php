<?php

/**
 * This is the CardHand Class
 * The CardHand class holds methods for creating card decks out of Card objects
 */

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var Card[] $hand holds Card
     */
    private array $hand = [];

    /**
     * @param Card $card Holds a card object
     */
    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * Shuffles the hand array
     */
    public function shuffle(): void
    {
        shuffle($this->hand);
    }

    /**
     * @return int Count of the hand array
     */
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

    /**
     * Adds all 52 card objects to hand array
     */
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

    /**
     * @return bool Return true if hand array is empty
     */
    public function empty(): bool
    {
        return empty($this->hand);
    }
}
