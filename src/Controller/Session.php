<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Session extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck") ?? new CardHand();
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        $amountLeft = $deck->getNumberCards();
        $cardsLeft = $deck->cardHand();

        $amountLeftUser = $userDeck->getNumberCards();
        $cardsLeftUser = $userDeck->cardHand();

        $sessionData = $session->all();

        $data = [
            "session" => $sessionData,
            "left" => $amountLeft,
            "hand" => $cardsLeft,
            "leftUser" => $amountLeftUser,
            "handUser" => $cardsLeftUser,
        ];

        return $this->render('session.twig', $data);
    }

    #[Route("/session/blackjack", name: "session_blackjack")]
    public function sessionBlackjack(
        SessionInterface $session
    ): Response {
        /** @var CardHand $playerDeck */
        $playerDeck = $session->get("playerDeck") ?? new CardHand();
        /** @var CardHand $houseDeck */
        $houseDeck = $session->get("houseDeck") ?? new CardHand();
        /** @var CardHand $boardDeck */
        $boardDeck = $session->get("boardDeck") ?? new CardHand();

        $amountLeft = $boardDeck->getNumberCards();

        $sessionData = $session->all();

        $data = [
            "left" => $amountLeft,
            "player" => $playerDeck->cardHand(),
            "house" => $houseDeck->cardHand(),
            "board" => $boardDeck->cardHand(),
        ];

        return $this->render('session_blackjack.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session was cleared'
        );

        return $this->redirectToRoute('session');
    }
}
