<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardHand()
    {
        $hand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $hand);

        $res = $hand->getNumberCards();
        $this->assertEmpty($res);
    }

    /**
     * Test if wholeDeck generates a deck of 52 cards.
     */
    public function testCardHandWholeDeck()
    {
        $cardHand = new CardHand();

        $wholeDeck = $cardHand->wholeDeck();
        $res = $cardHand->getNumberCards();
        $exp = 52;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test if shuffle generates a new deck unlike wholeDeck.
     */
    public function testCardHandShuffle()
    {
        $cardHandOne = new CardHand();
        $cardHandTwo = new CardHand();

        $cardHandOne->wholeDeck();
        $cardHandOne->shuffle();

        $shuffleDeck = $cardHandOne->cardHand();

        $cardHandTwo->wholeDeck();
        $nonShuffleDeck = $cardHandTwo->cardHand();

        $this->assertNotEquals($shuffleDeck, $nonShuffleDeck);
    }

    /**
     * Test if add method adds a card onto the deck correctly.
     */
    public function testCardHandAdd()
    {
        $cardHand = new CardHand();

        $cardHand->add(new Card("SS"));
        $cardHand->add(new Card("S2"));

        $deckArr = $cardHand->cardHand();
        $lastCard = end($deckArr)->getAsString();

        $lengthDeck = $cardHand->getNumberCards();

        $exp = "S2";

        $this->assertEquals($exp, $lastCard);
        $this->assertEquals(2, $lengthDeck);
    }

    /**
     * Test if methods cardToUnicode and getAsString returns correctly.
     */
    public function testCardHandUnicodeString()
    {
        $cardHand = new CardHand();

        $cardHand->add(new Card("SS"));
        $cardHand->add(new Card("S2"));

        $string = $cardHand->getAsString();
        $unicode = $cardHand->cardToUnicode();

        $exp1 = ["SS", "S2"];
        $exp2 = ["🂡", "🂢"];

        $this->assertEquals($exp1, $string);
        $this->assertEquals($exp2, $unicode);
    }

    /**
     * Test if empty and draw returns correctly.
     */
    public function testCardHandDraw()
    {
        $cardHand = new CardHand();
        $emptyHand = new CardHand();

        $cardHand->wholeDeck();

        $initialLen = $cardHand->getNumberCards();

        $cardHand->draw();

        $afterLen = $cardHand->getNumberCards();

        $isEmpty = $emptyHand->empty();

        $this->assertEquals(52, $initialLen);
        $this->assertEquals(51, $afterLen);
        $this->assertEquals(true, $isEmpty);
    }
}
