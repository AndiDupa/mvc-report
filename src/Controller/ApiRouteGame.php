<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Card\Card;
use App\Card\CardGame;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiRouteGame extends AbstractController
{
    #[Route("/api/game", name: "game")]
    public function game(
        SessionInterface $session
    ): Response {
        /** @var CardHand $houseDeck */
        $houseDeck = $session->get("houseDeck") ?? new CardHand();
        /** @var CardHand $playerDeck */
        $playerDeck = $session->get("playerDeck") ?? new CardHand();
        /** @var CardHand $boardDeck */
        $boardDeck = $session->get("boardDeck") ?? new CardHand();

        /** @var bool $isSet */
        $isSet = $session->get("isSet") ?? false;
        $reveal = $session->get("reveal") ?? false;

        $game = new CardGame();

        $game->createDecks($boardDeck, $houseDeck, $playerDeck, $session);

        $playerScore = $game->setScore($playerDeck, $session, "playerPoints");
        $houseScore = $game->setScore($houseDeck, $session, "housePoints");

        $result = $game->winChecker($houseDeck, $playerDeck, $isSet);

        $data = [
            "houseDeck" => $houseDeck->cardHand(),
            "playerDeck" => $playerDeck->cardHand(),
            "housePoints" => $houseScore,
            "playerPoints" => $playerScore,
            "isSet" => $isSet,
            "result" => $result,
            "reveal" => $reveal,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
