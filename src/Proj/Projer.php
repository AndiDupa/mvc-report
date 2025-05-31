<?php

/**
 * This is the RoomHandler Class
 * The RoomHandler class holds methods for creating RoomHandler objects
 */

namespace App\Proj;

class Projer
{
    /**
     * @var string $value Is string value of the RoomHandler object
    */
    public string $value;

    /**
     * @var array $value Is array value of the RoomHandler object
    */
    public array $generalActions = [
        "look around",
        "look at door",
        "pick up key",
        "check door",
        "open door",
        "go north",
        "go west",
        "go south",
        "go east",
        "go up",
        "go left",
        "go down",
        "go right",
        "check chest",
        "open chest"
    ];

    public array $allRooms = [
        "Bedroom",
        "Hallway",
        "Bathroom",
        "Lower floor",
        "Outside"
    ];

    // public function __construct(string $value = "")
    // {
    //     $this->value = $value;
    // }

    public function __construct(string $value = "")
    {
        $roomsJson = file_get_contents(__DIR__ . "/rooms.json");

        $this->rooms = json_decode($roomsJson, true);
    }

    public function roomName(string $value) {
        $newVal = strtolower($value);

        return $this->rooms[$newVal];
    }


    // /**
    //  * @return string $value holds room image based on inputted value
    //  */
    // public function getImage($value): string
    // {
    //     $newVal = strtolower($value);

    //     $possibleImg = [
    //         "bedroom" => "img/proj_rooms/image_1.png",
    //         "hallway" => "img/",
    //         "bathroom" => "img/",
    //         "lower floor" => "img/",
    //         "outside" => "img/",
    //     ];

    //     return $possibleImg[$newVal];
    // }

    /**
     * @return array $value holds room image based on inputted value
     */
    public function action(string $room, string $action, array $inventory): array
    {
        $newVal = strtolower($action);
        $currRoom = $room;

        if (!isset($this->rooms[$currRoom]["actions"])) {
            return [
                "room" => $room,
                "msg" => $this->rooms[$currRoom]["desc"],
                "add" => null,
                "remove" => null,
                "image" => $this->rooms[$currRoom]["image"]
            ];
        }

        $res = $this->rooms[$currRoom]["actions"];

        if (!isset($res[$action])) {
            return [
                "room" => $room,
                "msg" => "Sorry, this program is too dumb to understand your genius.",
                "add" => null,
                "remove" => null,
                "image" => $this->rooms[$currRoom]["image"]
            ];
        }

        $res2 = $res[$action];
        $req = $res2["req"] ?? "";
        $resReturn = [
            "room" => $room,
            "msg" => $res2["msg"] ?? null,
            "add" => $res2["add"] ?? null,
            "remove" => $res2["remove"] ?? null,
            "image" => $this->rooms[$currRoom]["image"] ?? "img/proj_rooms/image_1.png"
        ];

        if (isset($res2["dead"]) && !in_array($req, $inventory)) {
            return [
                "room" => $room,
                "msg" => $res2["deadMsg"],
                "add" => null,
                "remove" => null,
                "image" => $res2["dead"]
            ];
        }

        if (is_string($res2)) {
            $resReturn["msg"] = $res2;
            return $resReturn;
        }

        if (isset($res2["msgImage"])) {
            $resReturn["image"] = $res2["msgImage"];
            $resReturn["msg"] = $res2["msg"];
            return $resReturn;
        }

        if ($req !== "" && !in_array($req, $inventory)) {
            $resReturn["msg"] = "You dont have the thing required to do that yet.";
            $resReturn["add"] = $res2["add"] ?? null;
            $resReturn["remove"] = $res2["remove"] ?? null;
            return $resReturn;
        }

        if (isset($res2["next"]) && ($req === "" || in_array($req, $inventory))) {
            $resReturn["room"] = $res2["next"];
            $resReturn["msg"] = $res2["msg"];
            $resReturn["image"] = $this->rooms[$res2["next"]]["image"];
            return $resReturn;
        }

        return $resReturn;

        // return [
        //     "room" => $res2["room"] ?? $room,
        //     "msg" => $res2["msg"] ?? "You certainly did something, but it wasnt described in the code.",
        //     "add" => $res2["add"] ?? null,
        //     "remove" => $res2["remove"] ?? null,
        //     "next" => $res2["next"] ?? null
        // ];
    }
}