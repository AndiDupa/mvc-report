<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for classes Room and RoomHandler.
 */
class RoomHandlerTest extends TestCase
{
    /**
     * 
     */
    public function testRoomHandlerRooms()
    {
        $roomHandler = new RoomHandler();
        $res = $roomHandler->getRooms();

        $this->assertIsArray($res);
    }

    /**
     * 
     */
    public function testRoomHandlerContainsRooms()
    {
        $roomHandler = new RoomHandler();
        $res = $roomHandler->getRooms();

        foreach($res as $room) {
            $this->assertInstanceOf("\App\Proj\Room", $room);
        }
    }

    public function testRoomHandlerRoomName()
    {
        $roomHandler = new RoomHandler();
        $res = $roomHandler->roomName("bedroom");

        $this->assertInstanceOf("\App\Proj\Room", $res);
        $this->assertEquals($res->image, "img/proj_rooms/image_1.png");
    }

    // /**
    //  * Test if roll method randomizes die.
    //  */
    // public function testDiceRoll()
    // {
    //     $die = new Dice();

    //     $dieVal = $die->getValue();

    //     $die->roll();

    //     $res = $die;

    //     $this->assertNotEquals($dieVal, $res);
    // }

    // /**
    //  * Test if getAsString returns correct value.
    //  */
    // public function testDiceGetAsString()
    // {
    //     $die = new Dice();

    //     $dieValRes = "[" . strval($die->getValue()) . "]";

    //     $res = $die->getAsString();

    //     $this->assertEquals($dieValRes, $res);
    // }
}
