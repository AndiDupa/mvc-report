<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Test if roll method randomizes die.
     */
    public function testDiceRoll()
    {
        $die = new Dice();

        $dieVal = $die->getValue();

        $die->roll();

        $res = $die;

        $this->assertNotEquals($dieVal, $res);
    }

    /**
     * Test if getAsString returns correct value.
     */
    public function testDiceGetAsString()
    {
        $die = new Dice();

        $dieValRes = "[" . strval($die->getValue()) . "]";

        $res = $die->getAsString();

        $this->assertEquals($dieValRes, $res);
    }
}
