<?php

/**
 * This is the RoomHandler Class
 * The RoomHandler class holds methods for creating RoomHandler objects
 */

namespace App\Proj;

class Room
{
    public string $name;
    public string $desc;
    public string $image;
    public array $actions;

    public function __construct(string $name, array $roomData)
    {
        $this->name = $name;
        $this->desc = $roomData["desc"] ?? "";
        $this->image = $roomData["image"] ?? "";
        $this->actions = $roomData["actions"] ?? [];
    }

    public function actionExists(string $value): bool
    {
        return isset($this->actions[$value]);
    }

    public function anyActionExists(): bool
    {
        return !empty($this->actions);
    }

    public function getAction(string $value): array
    {
        return $this->actions[$value] ?? null;
    }
}
