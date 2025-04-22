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
}
