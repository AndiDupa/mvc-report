<?php

namespace App\Card;

class CardGraphic
{
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

    public static function temper(array $deck): int
    {
        $temp = [];
        $sum = 0;
        // return CardGraphic::$point[$unicode] ?? null;
        foreach($deck as $element) {
            $temp[] = CardGraphic::$point[$element->cardToUnicode()];
        }

        foreach($temp as $individual_card) {
            $sum += $individual_card;
        }
        return $sum;
    }
}
