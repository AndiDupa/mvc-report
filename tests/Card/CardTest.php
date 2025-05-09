<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->getAsString();
        $this->assertEmpty($res);
    }

    /**
     * Test if cardToUnicode returns the correct string.
     */
    public function testCardUnicode()
    {
        $card = new Card("SS");

        $res = $card->cardToUnicode();
        $exp = "🂡";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test if cardToUnicode returns the correct string.
     */
    public function testCardColor()
    {
        $card = new Card("SS");

        $res = $card->cardColorClass();
        $exp = "spades";
        $this->assertEquals($exp, $res);
    }
}
