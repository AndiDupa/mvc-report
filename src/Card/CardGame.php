<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
            $sum += $individual_card;
        }

        if ($sum <= 10 && $temp2 === 1) {
            $sum += 11;
        } elseif ($sum >= 11 && $temp2 === 1) {
            $sum += 1;
        }

        return $sum;
    }

    public function winChecker(CardHand $houseDeck, CardHand $playerDeck, bool $isStay): array
    {
        $housePoints = CardGame::temper($houseDeck->cardHand());
        $playerPoints = CardGame::temper($playerDeck->cardHand());

        if ($playerPoints > 21) {
            return ["warning", "Bust! You lose with the hand $playerPoints."];
        }

        if ($housePoints === 21) {
            return ["warning", "You lose! The house got $housePoints."];
        }

        if ($housePoints > 21) {
            return ["success", "You win! The house bust with $housePoints."];
        }

        if ($housePoints > $playerPoints && $housePoints <= 21 && $isStay === true) {
            return ["warning", "You lose! The house got $housePoints."];
        }

        if ($housePoints === $playerPoints && $housePoints <= 21 && $isStay === true) {
            return ["warning", "You lose! The house got $housePoints."];
        }

        return [];
    }

    public function createDecks(CardHand $boardDeck, CardHand $houseDeck, CardHand $playerDeck, SessionInterface $session): void
    {
        if ($boardDeck->empty()) {
            $boardDeck->wholeDeck();
            $boardDeck->shuffle();

            for ($i = 0; $i < 2; $i++) {
                $houseDeck->add($boardDeck->draw());
                $playerDeck->add($boardDeck->draw());
            }

            $session->set("houseDeck", $houseDeck);
            $session->set("playerDeck", $playerDeck);
            $session->set("boardDeck", $boardDeck);
        }
    }

    public function setScore(CardHand $deck, SessionInterface $session, $player): int
    {
        $deckArr = $deck->cardHand();

        $deckScore = CardGame::temper($deckArr);

        $session->set($player, $deckScore);

        return $deckScore;
    }
}
