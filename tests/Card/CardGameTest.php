<?php

namespace App\Card;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGame.
 */
class CardGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardGame()
    {
        $cardGame = new CardGame();
        $this->assertInstanceOf("\App\Card\CardGame", $cardGame);
    }

    /**
     * Test if temper returns the correct score of deck.
     */
    public function testCardGameTemper()
    {
        $cardHand = new CardHand();
        $cardGame = new CardGame();

        $cardHand->add(new Card("SS"));
        $cardHand->add(new Card("SKu"));

        $res = $cardGame->temper($cardHand->cardHand());

        $this->assertEquals(21, $res);
    }

    /**
     * Test if winchecker returns correct array.
     */
    public function testCardGameWinCheckerOne()
    {
        $cardGame = new CardGame();

        $houseHand = new CardHand();

        $houseHand->add(new Card("SKu"));
        $houseHand->add(new Card("HKu"));
        $houseHand->add(new Card("RKu"));

        $playerHand = new CardHand();

        $playerHand->add(new Card("SS"));
        $playerHand->add(new Card("SKu"));

        $res = $cardGame->winChecker($houseHand, $playerHand, true);

        $exp = ["success", "You win! The house bust with 30."];

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if winchecker returns correct array.
     */
    public function testCardGameWinCheckerTwo()
    {
        $cardGame = new CardGame();

        $playerHand = new CardHand();

        $playerHand->add(new Card("SKu"));
        $playerHand->add(new Card("HKu"));
        $playerHand->add(new Card("RKu"));

        $houseHand = new CardHand();

        $houseHand->add(new Card("SS"));
        $houseHand->add(new Card("SKu"));

        $res = $cardGame->winChecker($houseHand, $playerHand, true);

        $exp = ["warning", "Bust! You lose with the hand 30."];

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if winchecker returns correct array.
     */
    public function testCardGameWinCheckerThree()
    {
        $cardGame = new CardGame();

        $playerHand = new CardHand();

        $playerHand->add(new Card("HS"));
        $playerHand->add(new Card("HKu"));

        $houseHand = new CardHand();

        $houseHand->add(new Card("SS"));
        $houseHand->add(new Card("SKu"));

        $res = $cardGame->winChecker($houseHand, $playerHand, true);

        $exp = ["warning", "You lose! The house got 21."];

        $this->assertEquals($exp, $res);
    }

    /**
     * Test if winchecker returns correct array.
     */
    public function testCardGameWinCheckerFour()
    {
        $cardGame = new CardGame();

        $houseHand = new CardHand();

        $houseHand->add(new Card("KKu"));
        $houseHand->add(new Card("HKu"));

        $playerHand = new CardHand();

        $playerHand->add(new Card("S2"));
        $playerHand->add(new Card("SKu"));

        $res = $cardGame->winChecker($houseHand, $playerHand, true);

        $exp = ["warning", "You lose! The house got 20."];

        $this->assertEquals($exp, $res);

        $playerHand->add(new Card("S8"));

        $res = $cardGame->winChecker($houseHand, $playerHand, true);

        $exp = ["warning", "You lose! The house got 20."];

        $this->assertEquals($exp, $res);

        $houseHand = new CardHand();

        $res = $cardGame->winChecker($houseHand, $playerHand, true);

        $exp = [];

        $this->assertEquals($exp, $res);
    }

    // There are no more tests because the other methods require session.
}
