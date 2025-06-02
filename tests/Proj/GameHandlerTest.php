<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for classes GameHandler.
 */
class GameHandlerTest extends TestCase
{
    /**
     * Tests if RoomHandler->getRooms() returns an array of all the rooms in the JSON file.
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

    // /**
    //  * @param string $room contains the room name
    //  * @param string $action contains the action name
    //  * @param array<string> $inventory contains items in the player's inventory
    //  * @return array<string, mixed> contains formatted game data
    //  */
    // public function action(string $room, string $action, array $inventory): array
    // {
    //     $currRoom = $this->rooms[$room];

    //     if (!$currRoom->anyActionExists()) {
    //         return [
    //             "room" => $room,
    //             "msg" => $currRoom->desc,
    //             "add" => null,
    //             "remove" => null,
    //             "image" => $currRoom->image
    //         ];
    //     }

    //     $allActions = $currRoom->actions;

    //     if (!$currRoom->actionExists($action)) {
    //         return [
    //             "room" => $room,
    //             "msg" => "Sorry, this program is too dumb to understand your genius.",
    //             "add" => null,
    //             "remove" => null,
    //             "image" => $currRoom->image
    //         ];
    //     }

    //     $singleAction = $allActions[$action];

    //     /** @var string $req contains required item for committing action */
    //     $req = $singleAction["req"] ?? "";
    //     $resReturn = [
    //         "room" => $room,
    //         "msg" => $singleAction["msg"] ?? null,
    //         "add" => $singleAction["add"] ?? null,
    //         "remove" => $singleAction["remove"] ?? null,
    //         "image" => $currRoom->image ?? "img/proj_rooms/image_1.png"
    //     ];

    //     if (isset($singleAction["dead"]) && !in_array($req, $inventory)) {
    //         return [
    //             "room" => $room,
    //             "msg" => $singleAction["deadMsg"],
    //             "add" => null,
    //             "remove" => null,
    //             "image" => $singleAction["dead"]
    //         ];
    //     }

    //     if (is_string($singleAction)) {
    //         $resReturn["msg"] = $singleAction;
    //         return $resReturn;
    //     }

    //     if (isset($singleAction["msgImage"])) {
    //         $resReturn["image"] = $singleAction["msgImage"];
    //         $resReturn["msg"] = $singleAction["msg"];
    //         return $resReturn;
    //     }

    //     $resReturn = $this->hasItem($singleAction, $req, $inventory, $resReturn);

    //     return $resReturn;
    // }

    // public function __construct()
    // {
    //     $this->roomHandler = new RoomHandler();
    //     $this->rooms = $this->roomHandler->getRooms();
    // }


    // /**
    //  * Tests if RoomHandler->getRooms contains an array of Room objects.
    //  */
    // public function testRoomHandlerContainsRooms()
    // {
    //     $roomHandler = new RoomHandler();
    //     $res = $roomHandler->getRooms();

    //     foreach($res as $room) {
    //         $this->assertInstanceOf("\App\Proj\Room", $room);
    //     }
    // }

    // /**
    //  * Tests if "bedroom" exists within the rooms in roomHandler (which it should).
    //  */
    // public function testRoomHandlerRoomName()
    // {
    //     $roomHandler = new RoomHandler();
    //     $res = $roomHandler->roomName("bedroom");

    //     $this->assertInstanceOf("\App\Proj\Room", $res);
    //     $this->assertEquals($res->image, "img/proj_rooms/image_1.png");
    // }

    // /**
    //  * Tests if its possible to create a new Room object, and that the "look" action exists.
    //  */
    // public function testRoomCreate()
    // {
    //     $roomData = [
    //         "desc" => "A grand castle.",
    //         "image" => "img/proj_rooms/image_1.png",
    //         "actions" => [
    //             "look" => "You see a large king's chair in front of you."
    //         ]
    //     ];

    //     $room = new Room("castle", $roomData);

    //     $this->assertEquals($room->name, "castle");
    //     $this->assertEquals($room->desc, "A grand castle.");
    //     $this->assertTrue($room->actionExists("look"));
    // }

    // /**
    //  * Test if actions exists within the Room object.
    //  */
    // public function testRoomActions()
    // {
    //     $roomData = [
    //         "desc" => "A grand castle.",
    //         "image" => "img/proj_rooms/image_1.png",
    //         "actions" => [
    //             "look" => "You see a large king's chair in front of you."
    //         ]
    //     ];

    //     $room = new Room("castle", $roomData);

    //     $this->assertTrue($room->anyActionExists());
    // }

    // /**
    //  * Tests that the "jump" action exists and contains the correct message.
    //  */
    // public function testRoomGetAction()
    // {
    //     $roomData = [
    //         "desc" => "A grand castle.",
    //         "image" => "img/proj_rooms/image_1.png",
    //         "actions" => [
    //             "look" => "You see a large king's chair in front of you.",
    //             "jump" => "You jump through the ceiling and into the stars."
    //         ]
    //     ];

    //     $room = new Room("castle", $roomData);

    //     $this->assertIsArray($room->getAction("jump"));
    //     $this->assertEquals($room->getAction("jump")["msg"], "You jump through the ceiling and into the stars.");
    // }
}
