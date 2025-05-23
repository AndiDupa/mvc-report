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

class ApiRoute extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $routes = ["/api/quote"];

        $data = [
            "routes" => $routes,
        ];

        return $this->render('routes.html.twig', $data);
    }

    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
    {
        $number = random_int(0, 2);

        $quotes = ["I... Am Steve... - Steve", "THIS... IS A CRAFTING TABLE - Steve", "CHICKEN JOCKEY! - Steve"];
        $chosen = "";
        $timestamp = date("Y/m/d");
        $generated = date("H:i:s");

        if ($number === 0) {
            $chosen = $quotes[0];
        } elseif ($number === 1) {
            $chosen = $quotes[1];
        } else {
            $chosen = $quotes[2];
        }

        $data = [
            'quote' => $chosen,
            'timestamp' => $timestamp,
            'generated' => $generated,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "deck", methods: ['GET'])]
    public function jsonDeck(
        SessionInterface $session
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck");
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        if ($userDeck->getNumberCards() === 52 && $deck->empty()) {
            $cardCount = $deck->getNumberCards();
        } elseif ($deck == null) {
            $deck = new CardHand();
            $deck->wholeDeck();

            $userDeck = new CardHand();
            $cardCount = $deck->getNumberCards();

            $data = [
                'deck' => $deck->cardHand(),
                "cardsLeft" => $cardCount,
                "userDeck" => $userDeck->cardHand(),
            ];

            $session->set("deck", $deck);
        }

        $data = [
            'deck' => $deck->cardHand(),
            "cardsLeft" => 0,
            "userDeck" => $userDeck->cardHand(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/shuffleDeck", name: "shuffleDeck", methods: ['POST'])]
    public function jsonShuffleDeck(
        SessionInterface $session
    ): Response {
        $deck = new CardHand();
        $deck->wholeDeck();
        $deck->shuffle();

        $session->set("deck", $deck);
        $session->set("userDeck", new CardHand());

        return $this->redirectToRoute('deck');
    }

    #[Route("/api/deck/draw", name: "deckDraw", methods: ['POST'])]
    public function jsonDeckDraw(
        SessionInterface $session
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck");
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        if ($deck->empty()) {
            $response = new JsonResponse(
                ['error' => 'Youve either requested more cards than the amount left in the deck, or the deck is empty'],
            );
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        $currCard = $deck->draw();
        if ($currCard !== null) {
            $userDeck->add($currCard);
        }

        $session->set("deck", $deck);
        $session->set("userDeck", $userDeck);

        return $this->redirectToRoute('deck');
    }

    #[Route("/api/deck/draw/:{num<\d+>}", name: "deckDrawNum", methods: ['POST'])]
    public function jsonDeckDrawNum(
        Request $request,
        SessionInterface $session
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck") ?? new CardHand();
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();
        $num = $request->request->get('num');

        if ($deck->empty() || $deck->getNumberCards() < $num) {
            $response = new JsonResponse(
                ['error' => 'Youve either requested more cards than the amount left in the deck, or the deck is empty'],
            );
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        $showCard = [];

        for ($i = 0; $i < $num; $i++) {
            // if ($deck->empty()) {
            //     break;
            // }

            $card = $deck->draw();

            $showCard[] = $card;
            if ($card !== null) {
                $userDeck->add($card);
            }
        }

        $session->set("deck", $deck);
        $session->set("userDeck", $userDeck);

        return $this->redirectToRoute('deck');
    }

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
