<?php

/**
 * This is the RoomHandler Class
 * The RoomHandler class holds Room objects for an adventure game
 */

namespace App\Proj;

use App\Proj\Room;

class RoomHandler
{
    /** @var array<Room> $rooms contains Room objects */
    private array $rooms;

    public function __construct()
    {
        $roomsJson = (string) file_get_contents(__DIR__ . "/rooms.json");
        $roomsData = json_decode($roomsJson, true);
        $this->rooms = [];

        /** @var array<string, array<string, mixed>> $roomsData contains data for room including string and arrays */
        foreach ($roomsData as $room => $data) {
            $this->rooms[$room] = new Room($room, $data);
        }
    }

    public function roomName(string $value): Room
    {
        $newVal = strtolower($value);

        return $this->rooms[$newVal];
    }

    /**
     * @return array<Room> $rooms contains Room objects
     */
    public function getRooms(): array
    {
        return $this->rooms;
    }
}
