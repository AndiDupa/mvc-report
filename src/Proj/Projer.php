<?php

/**
 * This is the RoomHandler Class
 * The RoomHandler class holds methods for creating RoomHandler objects
 */

namespace App\Proj;

use App\Proj\RoomHandler;

class Projer
{
    /** @var array<string, Room> */
    private array $rooms;
    private RoomHandler $roomHandler;

    public function __construct()
    {
        $this->roomHandler = new RoomHandler();
        $this->rooms = $this->roomHandler->getRooms();
    }

    /**
     * @param string $room contains the room name
     * @param string $action contains the action name
     * @param array<string> $inventory contains items in the player's inventory
     * @return array<string, mixed> contains formatted game data
     */
    public function action(string $room, string $action, array $inventory): array
    {
        $newVal = strtolower($action);
        $currRoom = $this->rooms[$room];

        if (!$currRoom->anyActionExists()) {
            return [
                "room" => $room,
                "msg" => $currRoom->desc,
                "add" => null,
                "remove" => null,
                "image" => $currRoom->image
            ];
        }

        $allActions = $currRoom->actions;

        if (!$currRoom->actionExists($action)) {
            return [
                "room" => $room,
                "msg" => "Sorry, this program is too dumb to understand your genius.",
                "add" => null,
                "remove" => null,
                "image" => $currRoom->image
            ];
        }

        $singleAction = $allActions[$action];
        $req = $singleAction["req"] ?? "";
        $resReturn = [
            "room" => $room,
            "msg" => $singleAction["msg"] ?? null,
            "add" => $singleAction["add"] ?? null,
            "remove" => $singleAction["remove"] ?? null,
            "image" => $currRoom->image ?? "img/proj_rooms/image_1.png"
        ];

        if (isset($singleAction["dead"]) && !in_array($req, $inventory)) {
            return [
                "room" => $room,
                "msg" => $singleAction["deadMsg"],
                "add" => null,
                "remove" => null,
                "image" => $singleAction["dead"]
            ];
        }

        if (is_string($singleAction)) {
            $resReturn["msg"] = $singleAction;
            return $resReturn;
        }

        if (isset($singleAction["msgImage"])) {
            $resReturn["image"] = $singleAction["msgImage"];
            $resReturn["msg"] = $singleAction["msg"];
            return $resReturn;
        }

        $resReturn = $this->hasItem($singleAction, $req, $inventory, $resReturn);

        return $resReturn;
    }

    /**
     * @param array<string> $singleAction contains the chosen actions variables
     * @param string $req contains the requirement to do the action
     * @param array<string> $inventory contains items in the players inventory
     * @param array<string, mixed> $resReturn contains formatted game data
     * @return array<string, mixed> $resReturn contains formatted game data
     */
    public function hasItem(array $singleAction, string $req, array $inventory, array $resReturn): array
    {
        if ($req !== "" && !in_array($req, $inventory)) {
            $resReturn["msg"] = "You dont have the thing required to do that yet.";
            $resReturn["add"] = $singleAction["add"] ?? null;
            $resReturn["remove"] = $singleAction["remove"] ?? null;
            return $resReturn;
        }

        if (isset($singleAction["next"]) && ($req === "" || in_array($req, $inventory))) {
            $resReturn["room"] = $singleAction["next"];
            $resReturn["msg"] = $singleAction["msg"];
            $resReturn["image"] = $this->rooms[$singleAction["next"]]->image;
            return $resReturn;
        }

        return $resReturn;
    }
}