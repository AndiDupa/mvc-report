<?php

/**
 * This is the CardGame Class
 * The CardGame class holds methods for handling the blackjack game
 */

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGame
{
    /**
     * @param Card[] $deck Holds an array of Card objects
     */
    public static function temper(array $deck): int
    {
        $sum = 0;
        $ace = 0;

        $graphic = new CardGraphic();

        foreach ($deck as $element) {
            $temp = $graphic->cardPoint($element->cardToUnicode());

            if ($temp === 1) {
                $ace++;
            }

            $sum += $temp;
        }

        while ($ace > 0 && $sum + 10 <= 21) {
            $sum += 10;
            $ace--;
        }

        return $sum;
    }

    /**
     * @return string[] $result Return a flash message
     */
    public function winChecker(CardHand $houseDeck, CardHand $playerDeck, bool $isStay): array
    {
        $housePoints = self::temper($houseDeck->cardHand());
        $playerPoints = self::temper($playerDeck->cardHand());

        $result = $this->winCheckerPlayer($playerPoints);
        if (!empty($result)) {
            return $result;
        }

        $result = $this->winCheckerHouse($housePoints, $playerPoints, $isStay);

        return $result;
    }

    /**
     * @return string[] $result Return a flash message
     */
    public function winCheckerHouse(int $housePoints, int $playerPoints, bool $isStay): array
    {
        if ($housePoints === 21) {
            return ["warning", "You lose! The house got $housePoints."];
        }

        if ($housePoints > 21) {
            return ["success", "You win! The house bust with $housePoints."];
        }

        if ($housePoints > $playerPoints && $isStay === true) {
            return ["warning", "You lose! The house got $housePoints."];
        }

        if ($housePoints === $playerPoints && $isStay === true) {
            return ["warning", "You lose! The house got $housePoints."];
        }

        return [];
    }

    /**
     * @return string[] $result Return a flash message
     */
    public function winCheckerPlayer(int $playerPoints): array
    {
        if ($playerPoints > 21) {
            return ["warning", "Bust! You lose with the hand $playerPoints."];
        }

        return [];
    }

    /**
     * @param CardHand $boardDeck holds the board deck
     * @param CardHand $houseDeck holds the dealers deck
     * @param CardHand $playerDeck holds the players deck
     * @param SessionInterface $session holds the session
     */
    public function createDecks(CardHand $boardDeck, CardHand $houseDeck, CardHand $playerDeck, SessionInterface $session): void
    {
        if ($boardDeck->empty()) {
            $boardDeck->wholeDeck();
            $boardDeck->shuffle();

            for ($i = 0; $i < 2; $i++) {
                $draw = $boardDeck->draw();
                if ($draw !== null) {
                    $houseDeck->add($draw);
                }

                $draw = $boardDeck->draw();
                if ($draw !== null) {
                    $playerDeck->add($draw);
                }
            }

            $session->set("houseDeck", $houseDeck);
            $session->set("playerDeck", $playerDeck);
            $session->set("boardDeck", $boardDeck);
        }
    }

    /**
     * @return int set score in session and return the score it set
     */
    public function setScore(CardHand $deck, SessionInterface $session, string $player): int
    {
        $game = new CardGame();

        $deckArr = $deck->cardHand();

        $deckScore = $game->temper($deckArr);

        $session->set($player, $deckScore);

        return $deckScore;
    }
}
