<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_home")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "deck_card")]
    public function showDeck(
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
            $userDeck = new CardHand();

            $deck->wholeDeck();

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

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck_card_shuffle")]
    public function shuffledDeck(
        SessionInterface $session
    ): Response {
        $deck = new CardHand();

        $deck->wholeDeck();

        $deck->shuffle();

        $session->set("deck", $deck);
        $session->set("userDeck", new CardHand());

        $data = [
            "deck" => $deck->cardHand(),
            "bool" => "",
            "userDeck" => $session->get("userDeck"),
        ];

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "deck_card_draw")]
    public function drawFromDeck(
        SessionInterface $session
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck");
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        if ($deck->empty()) {
            $this->addFlash(
                'warning',
                'There are no cards left in the deck!'
            );
        }

        $currCard = $deck->draw();

        if ($currCard !== null) {
            $userDeck->add($currCard);

            $currCardUnicode = $currCard->cardToUnicode();

            $data = [
                "color" => $currCard->cardColorClass(),
                "draw" => $currCardUnicode,
                "bool" => "",
                "userDeck" => $userDeck->cardHand(),
            ];

            $session->set("deck", $deck);
            $session->set("userDeck", $userDeck);
            return $this->render('card/test/draw.html.twig', $data);
        }
        $this->addFlash(
            'warning',
            'There are no cards left in the deck!'
        );

        return $this->redirectToRoute('deck_card');
    }

    # this route is for typing in the link manually
    #[Route("/card/deck/draw/:{num<\d+>}", name: "deck_card_draw_num_get", methods: ['GET'])]
    public function drawNumFromDeckGet(
        SessionInterface $session,
        int $num
    ): Response {
        /** @var CardHand $deck */
        $deck = $session->get("deck");
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        if ($deck->empty()) {
            $this->addFlash(
                'warning',
                'There are no cards left in the deck!'
            );
            return $this->redirectToRoute('deck_card');
        }
        if ($deck->getNumberCards() < $num) {
            $this->addFlash(
                'warning',
                "You can't draw more cards than there are in the deck!"
            );
            return $this->redirectToRoute('deck_card');
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

        $data = [
            "draw" => $showCard,
            "userDeck" => $userDeck->cardHand(),
            "num" => $num,
        ];

        return $this->render('card/test/draw.html.twig', $data);
    }

    # this route is for the 21 game page
    #[Route("/card/deck/draw/page", name: "deck_card_draw_num", methods: ['POST'])]
    public function drawNumFromDeck(
        SessionInterface $session,
        Request $request
    ): Response {
        /** @var int $num */
        $num = $request->request->get('num');
        /** @var CardHand $deck */
        $deck = $session->get("deck");
        /** @var CardHand $userDeck */
        $userDeck = $session->get("userDeck") ?? new CardHand();

        if ($deck->empty()) {
            $this->addFlash(
                'warning',
                'There are no cards left in the deck!'
            );
            return $this->redirectToRoute('deck_card');
        }
        if ($deck->getNumberCards() < $num) {
            $this->addFlash(
                'warning',
                "You can't draw more cards than there are in the deck!"
            );
            return $this->redirectToRoute('deck_card');
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

        $data = [
            "draw" => $showCard,
            "userDeck" => $userDeck->cardHand(),
        ];

        return $this->render('card/test/draw.html.twig', $data);
    }
}
