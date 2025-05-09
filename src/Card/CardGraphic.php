<?php

namespace App\Card;

class CardGraphic
{
    /**
     * @var array<string, string> $representation
    */
    public static array $representation = [
        # spades
        "SS" => "🂡",
        "S2" => "🂢",
        "S3" => "🂣",
        "S4" => "🂤",
        "S5" => "🂥",
        "S6" => "🂦",
        "S7" => "🂧",
        "S8" => "🂨",
        "S9" => "🂩",
        "S10" => "🂪",
        "SKn" => "🂫",
        "SDr" => "🂭",
        "SKu" => "🂮",
        # hearts
        "HS" => "🂱",
        "H2" => "🂲",
        "H3" => "🂳",
        "H4" => "🂴",
        "H5" => "🂵",
        "H6" => "🂶",
        "H7" => "🂷",
        "H8" => "🂸",
        "H9" => "🂹",
        "H10" => "🂺",
        "HKn" => "🂻",
        "HDr" => "🂽",
        "HKu" => "🂾",
        # diamonds
        "RS" => "🃁",
        "R2" => "🃂",
        "R3" => "🃃",
        "R4" => "🃄",
        "R5" => "🃅",
        "R6" => "🃆",
        "R7" => "🃇",
        "R8" => "🃈",
        "R9" => "🃉",
        "R10" => "🃊",
        "RKn" => "🃋",
        "RDr" => "🃍",
        "RKu" => "🃎",
        # clubs
        "KS" => "🃑",
        "K2" => "🃒",
        "K3" => "🃓",
        "K4" => "🃔",
        "K5" => "🃕",
        "K6" => "🃖",
        "K7" => "🃗",
        "K8" => "🃘",
        "K9" => "🃙",
        "K10" => "🃚",
        "KKn" => "🃛",
        "KDr" => "🃝",
        "KKu" => "🃞"
    ];

    /**
     * @var array<string, int> $point
    */
    public static array $point = [
        # spades
        "🂡" => 1,
        "🂢" => 2,
        "🂣" => 3,
        "🂤" => 4,
        "🂥" => 5,
        "🂦" => 6,
        "🂧" => 7,
        "🂨" => 8,
        "🂩" => 9,
        "🂪" => 10,
        "🂫" => 10,
        "🂭" => 10,
        "🂮" => 10,
        # hearts
        "🂱" => 1,
        "🂲" => 2,
        "🂳" => 3,
        "🂴" => 4,
        "🂵" => 5,
        "🂶" => 6,
        "🂷" => 7,
        "🂸" => 8,
        "🂹" => 9,
        "🂺" => 10,
        "🂻" => 10,
        "🂽" => 10,
        "🂾" => 10,
        # diamonds
        "🃁" => 1,
        "🃂" => 2,
        "🃃" => 3,
        "🃄" => 4,
        "🃅" => 5,
        "🃆" => 6,
        "🃇" => 7,
        "🃈" => 8,
        "🃉" => 9,
        "🃊" => 10,
        "🃋" => 10,
        "🃍" => 10,
        "🃎" => 10,
        # clubs
        "🃑" => 1,
        "🃒" => 2,
        "🃓" => 3,
        "🃔" => 4,
        "🃕" => 5,
        "🃖" => 6,
        "🃗" => 7,
        "🃘" => 8,
        "🃙" => 9,
        "🃚" => 10,
        "🃛" => 10,
        "🃝" => 10,
        "🃞" => 10
    ];

    /**
     * @param string $cardValue Holds string value of card
     * @return string Returns a string of the card type based on the prefix
     */
    public static function cardColor(string $cardValue): string
    {
        if ($cardValue[0] === "S") {
            return "spades";
        }
        if ($cardValue[0] === "H") {
            return "hearts";
        }
        if ($cardValue[0] === "R") {
            return "diamonds";
        }
        if ($cardValue[0] === "K") {
            return "clubs";
        }

        return "";
    }

    /**
     * @param string $cardValue holds string value of card
     * @return string Returns a string of the unicode equivalent of the card abbreviation
     */
    public static function cardUnicode(string $cardValue): string
    {
        return self::$representation[$cardValue] ?? "";
    }

    /**
     * @param string $cardValue holds string value of card
     * @return int Returns an int point equivalent of the card
     */
    public static function cardPoint(string $cardValue): int
    {
        return self::$point[$cardValue] ?? 0;
    }

    /**
     * @param Card[] $deck convert to score
    */
    public static function temper(array $deck): int
    {
        $temp = [];
        $sum = 0;

        foreach ($deck as $element) {
            $temp[] = self::$point[$element->cardToUnicode()];
        }

        foreach ($temp as $individualCard) {
            $sum += $individualCard;
        }
        return $sum;
    }
}
