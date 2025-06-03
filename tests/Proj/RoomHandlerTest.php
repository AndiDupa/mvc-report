<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for classes Room and RoomHandler.
 */
class RoomHandlerTest extends TestCase
{
    /**
     * Tests if RoomHandler->getRooms() returns an array of all the rooms in the JSON file.
     */
    public function testRoomHandlerRooms()
    {
        $roomHandler = new RoomHandler();
        $res = $roomHandler->getRooms();

        $this->assertIsArray($res);
    }

    /**
     * Tests if RoomHandler->getRooms contains an array of Room objects.
     */
    public function testRoomHandlerContainsRooms()
    {
        $roomHandler = new RoomHandler();
        $res = $roomHandler->getRooms();

        foreach($res as $room) {
            $this->assertInstanceOf("\App\Proj\Room", $room);
        }
    }

    /**
     * Tests if "bedroom" exists within the rooms in roomHandler (which it should).
     */
    public function testRoomHandlerRoomName()
    {
        $roomHandler = new RoomHandler();
        $res = $roomHandler->roomName("bedroom");

        $this->assertInstanceOf("\App\Proj\Room", $res);
        $this->assertEquals($res->image, "img/proj_rooms/image_1.png");
    }

    /**
     * Tests if its possible to create a new Room object, and that the "look" action exists.
     */
    public function testRoomCreate()
    {
        $roomData = [
            "desc" => "A grand castle.",
            "image" => "img/proj_rooms/image_1.png",
            "actions" => [
                "look" => "You see a large king's chair in front of you."
            ]
        ];

        $room = new Room("castle", $roomData);

        $this->assertEquals($room->name, "castle");
        $this->assertEquals($room->desc, "A grand castle.");
        $this->assertTrue($room->actionExists("look"));
    }

    /**
     * Test if actions exists within the Room object.
     */
    public function testRoomActions()
    {
        $roomData = [
            "desc" => "A grand castle.",
            "image" => "img/proj_rooms/image_1.png",
            "actions" => [
                "look" => "You see a large king's chair in front of you."
            ]
        ];

        $room = new Room("castle", $roomData);

        $this->assertTrue($room->anyActionExists());
    }

    /**
     * Tests that the "jump" action exists and contains the correct message.
     */
    public function testRoomGetAction()
    {
        $roomData = [
            "desc" => "A grand castle.",
            "image" => "img/proj_rooms/image_1.png",
            "actions" => [
                "look" => "You see a large king's chair in front of you.",
                "jump" => "You jump through the ceiling and into the stars."
            ]
        ];

        $room = new Room("castle", $roomData);

        $this->assertIsArray($room->getAction("jump"));
        $this->assertEquals($room->getAction("jump")["msg"], "You jump through the ceiling and into the stars.");
    }

    /**
     * Tests that the "look" action exists and contains the correct message.
     */
    public function testRoomGetActionTwo()
    {
        $roomData = [
            "desc" => "A grand castle.",
            "image" => "img/proj_rooms/image_1.png",
            "actions" => [
                "look" => [
                    "msg" => "You see a large king's chair in front of you."
                ]
            ]
        ];

        $room = new Room("castle", $roomData);

        $this->assertIsArray($room->getAction("look"));
        $this->assertEquals($room->getAction("look")["msg"], "You see a large king's chair in front of you.");
    }

    /**
     * Tests if no action exists.
     */
    public function testRoomGetActionThree()
    {
        $roomData = [
            "desc" => "A grand castle.",
            "image" => "img/proj_rooms/image_1.png"
        ];

        $room = new Room("castle", $roomData);

        $this->assertEquals($room->getAction("look"), null);
    }
}
