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
        $deck = $session->get("deck") ?? new CardHand();
        $userDeck = $session->get("userDeck") ?? new CardHand();

        $amountLeft= $deck->getNumberCards();
        $cardsLeft= $deck->cardHand();

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
