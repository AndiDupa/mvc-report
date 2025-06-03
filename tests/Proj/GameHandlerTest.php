<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for classes GameHandler.
 */
class GameHandlerTest extends TestCase
{
    /**
     * Tests if item requirements work.
     */
    public function testGameHandlerActionWithoutItem()
    {
        $gameHandler = new GameHandler();

        $inventory = [];
        $room = "bedroom";
        $action = "open door";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "You dont have the thing required to do that yet.");
    }

    /**
     * Tests if item requirements work when player has the item.
     */
    public function testGameHandlerActionWithItem()
    {
        $gameHandler = new GameHandler();

        $inventory = ["key"];
        $room = "bedroom";
        $action = "open door";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "You use the key to unlock the door and enter the hallway...");
    }

    /**
     * Tests if user inputted action doesn't exist.
     */
    public function testGameHandlerActionNotExist()
    {
        $gameHandler = new GameHandler();

        $inventory = [];
        $room = "bedroom";
        $action = "";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "Sorry, this program is too dumb to understand your genius.");
    }

    /**
     * Tests if room with no actions returns the room description.
     */
    public function testGameHandlerNoActions()
    {
        $gameHandler = new GameHandler();

        $inventory = [];
        $room = "windungeon";
        $action = "";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "YOU'RE A WINNER! You might not be able to do anything with the money, since you're locked in a dungeon and all, but at least you have a sick plushie and fat stacks!");
    }

    /**
     * Tests if room action results in death and the correct message is displayed.
     */
    public function testGameHandlerDead()
    {
        $gameHandler = new GameHandler();

        $inventory = [];
        $room = "hallway";
        $action = "open door";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "You DIE!!! You enter the door, walking straight into the open mouth of a spooky beast...");
    }

    /**
     * Tests if msgImage works and the correct message is displayed.
     */
    public function testGameHandlerMsgImage()
    {
        $gameHandler = new GameHandler();

        $inventory = [];
        $room = "bathroom";
        $action = "look at light switch";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "Just a normal light switch.");
    }

    /**
     * Tests if an action with just a message returns correctly.
     */
    public function testGameHandlerSingleMsg()
    {
        $gameHandler = new GameHandler();

        $inventory = [];
        $room = "bathroom";
        $action = "look around";

        $res = $gameHandler->action($room, $action, $inventory);

        $this->assertIsArray($res);
        $this->assertEquals($res["msg"], "The bathroom is dark and spooky... what the actual heck... Oh! There's a light switch beside you.");
    }
}
