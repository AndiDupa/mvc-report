<?php

/**
 * This is the Room Class
 * The Room class holds methods for creating Room objects for an adventure game
 */

namespace App\Proj;

class Room
{
    public string $name;
    public string $desc;
    public string $image;

    /** @var array<string, string|array<string, mixed>> $actions contains actions for given room */
    public array $actions;

    /**
     * @param string $name contains room name
     * @param array<string, mixed> $roomData
     */
    public function __construct(string $name, array $roomData)
    {
        $this->name = $name;
        $this->desc = self::getString($roomData["desc"] ?? null);
        $this->image = self::getString($roomData["image"] ?? null);
        $this->actions = self::getActions($roomData["actions"] ?? null);
    }

    public function actionExists(string $value): bool
    {
        return isset($this->actions[$value]);
    }

    public function anyActionExists(): bool
    {
        return !empty($this->actions);
    }

    /**
     * @param string $value contains action name
     * @return array<string, mixed>|null returns string or array based on action
     */
    public function getAction(string $value): ?array
    {
        $action = $this->actions[$value] ?? null;

        if (is_array($action)) {
            return $action;
        }

        if (is_string($action)) {
            return ["msg" => $action];
        }

        return null;
    }

    /**
     * @param mixed $value contains roomData strings
     * @return string $value returns string of value
     */
    private static function getString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        return "";
    }

    /**
     * @param mixed $value contains action for roomData
     * @return array<string, string|array<string, mixed>> $value contains array of values for action
     */
    private static function getActions(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        /** @var array<string, string|array<string, mixed>> $value */
        return $value;
    }
}
