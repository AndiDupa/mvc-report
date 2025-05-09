<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphic.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardGraphic()
    {
        $cardGraphic = new CardGraphic();

        $this->assertInstanceOf("\App\Card\CardGraphic", $cardGraphic);
    }

    /**
     * Test if cardCode returns correct score.
     */
    public function testCardGraphicCardPoint()
    {
        $card = new Card("SKu");
        $cardGraphic = new CardGraphic();

        $res = $cardGraphic->cardPoint($card->cardToUnicode());
        $exp = 10;

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if temper returns correct score of deck.
     */
    public function testCardGraphicTemper()
    {
        $cardHand = new CardHand();
        $cardGraphic = new CardGraphic();

        $cardHand->add(new Card("SDr"));
        $cardHand->add(new Card("SKu"));

        $res = $cardGraphic->temper($cardHand->cardHand());
        $exp = 20;

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if cardColor returns the correct card type
     */
    public function testCardGraphicColor()
    {
        $cardGraphic = new CardGraphic();

        $res = $cardGraphic->cardColor("SS");

        $this->assertEquals("spades", $res);

        $res = $cardGraphic->cardColor("HS");

        $this->assertEquals("hearts", $res);

        $res = $cardGraphic->cardColor("RS");

        $this->assertEquals("diamonds", $res);

        $res = $cardGraphic->cardColor("KS");

        $this->assertEquals("clubs", $res);

        $res = $cardGraphic->cardColor("OO");

        $this->assertEquals("", $res);
    }
}
