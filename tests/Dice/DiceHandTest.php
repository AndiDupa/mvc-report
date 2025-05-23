<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceHand()
    {
        $dieHand = new DiceHand();
        $this->assertInstanceOf("\App\Dice\DiceHand", $dieHand);

        $res = $dieHand->getNumberDices();
        $this->assertEquals($res, 0);
    }

    /**
     * Test if add adds to hand.
     */
    public function testDiceAdd()
    {
        $dieHand = new DiceHand();

        $dieHandVal1 = $dieHand->getNumberDices();

        $dieHand->add(new Dice());

        $dieHandVal2 = $dieHand->getNumberDices();

        $this->assertNotEquals($dieHandVal1, $dieHandVal2);
    }

    /**
     * Test if getValue returns the correct value.
     */
    public function testDiceGetInt()
    {
        $dieHand = new DiceHand();

        $dieHandVal1 = $dieHand->add(new Dice(), new Dice(), new Dice());

        $valsInt = $dieHand->getValues();

        $this->assertIsInt($valsInt[0]);
    }

    /**
     * Test if getString returns the correct value.
     */
    public function testDiceGetString()
    {
        $dieHand = new DiceHand();

        $dieHandVal1 = $dieHand->add(new Dice(), new Dice(), new Dice());

        $valsStr = $dieHand->getString();

        $this->assertIsString($valsStr[0]);
    }
}
