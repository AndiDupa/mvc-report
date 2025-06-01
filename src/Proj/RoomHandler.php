<?php

/**
 * This is the RoomHandler Class
 * The RoomHandler class holds methods for creating RoomHandler objects
 */

namespace App\Proj;
use App\Proj\Room;

class RoomHandler
{
    private array $rooms;

    public function __construct(string $value = "")
    {
        $roomsJson = file_get_contents(__DIR__ . "/rooms.json");
        $roomsData = json_decode($roomsJson, true);
        $this->rooms = [];

        foreach($roomsData as $room => $data) {
            $this->rooms[$room] = new Room($room, $data);
        }
    }

    public function roomName(string $value): Room
    {
        $newVal = strtolower($value);

        return $this->rooms[$newVal];
    }

    public function getRooms(): array
    {
        return $this->rooms;
    }
}
