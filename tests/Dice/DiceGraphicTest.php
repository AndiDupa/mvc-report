<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceGraphic()
    {
        $diceGraphic = new DiceGraphic();

        $this->assertInstanceOf("\App\Dice\DiceGraphic", $diceGraphic);
    }

    /**
     * Test if diceCode returns correct score.
     */
    public function testDiceGraphicDicePoint()
    {
        $die = new DiceGraphic();
        $die->roll();

        $this->assertIsString($die->getAsString());
    }
}
