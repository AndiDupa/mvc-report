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

class ApiRouteCard extends AbstractController
{
    #[Route("/api/deck", name: "deck", methods: ['GET'])]
    public function jsonDeck(
        SessionInterface $session
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck");
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        if ($deck == null) {
            $deck = new CardHand();
            $deck->wholeDeck();

            $userDeck = new CardHand();

            $data = [
                'deck' => $deck->cardHand(),
                "cardsLeft" => $deck->getNumberCards(),
                "userDeck" => $userDeck->cardHand(),
            ];

            $session->set("deck", $deck);
        } else {
            $data = [
                'deck' => $deck->cardHand(),
                "cardsLeft" => $deck->getNumberCards(),
                "userDeck" => $userDeck->cardHand(),
            ];
        }

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
}
