<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;

class CardGame
{
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

    public static function temper(array $deck): int
    {
        $temp = [];
        $temp2 = 0;
        $sum = 0;

        foreach($deck as $element) {
            if(CardGame::$point[$element->cardToUnicode()] == 1) {
                $temp2 = CardGame::$point[$element->cardToUnicode()];
            } else {
                $temp[] = CardGame::$point[$element->cardToUnicode()];
            }
        }

        foreach($temp as $individual_card) {
            echo($individual_card);
            $sum += $individual_card;
        }

        // echo("HALOO");

        if ($sum <= 10 && $temp2 === 1) {
            echo("RUNNING");
            $sum += 11;
        } elseif ($sum >= 11 && $temp2 === 1) {
            $sum += 1;
        }

        return $sum;
    }

    // public function unicodeArray(CardHand $hand): array
    // {
    //     $res_array = [];
    //     foreach($hand as $element) {
    //         $res_array[] = $element->cardToUnicode();
    //     }
    //     return $res_array;
    // }
}
