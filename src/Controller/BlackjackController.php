<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Card\Card;
use App\Card\CardGame;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BlackjackController extends AbstractController
{
    #[Route("/game", name: "blackjack")]
    public function home(): Response
    {
        return $this->render('card/blackjack.html.twig');
    }

    #[Route("/game/doc", name: "blackjack_doc")]
    public function doc(): Response
    {
        return $this->render('card/blackjack_doc.html.twig');
    }

    #[Route("/blackjack/start", name: "blackjack_start")]
    public function blackjackStart(
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

        if ($result) {
            $this->addFlash(
                $result[0],
                $result[1]
            );

            $session->clear();

            return $this->render('card/blackjack_game.html.twig', $data);
        }

        return $this->render('card/blackjack_game.html.twig', $data);
    }

    #[Route("/blackjack/call", name: "blackjack_call", methods: ["GET"])]
    public function blackjackCall(
        SessionInterface $session
    ): Response {
        /** @var CardHand $playerDeck */
        $playerDeck = $session->get("playerDeck");
        /** @var CardHand $boardDeck */
        $boardDeck = $session->get("boardDeck");

        $draw = $boardDeck->draw();

        if ($draw !== null) {
            $playerDeck->add($draw);
        }

        $session->set("boardDeck", $boardDeck);
        $session->set("playerDeck", $playerDeck);

        return $this->redirectToRoute('blackjack_start');
    }

    #[Route("/blackjack/stay", name: "blackjack_stay", methods: ["GET"])]
    public function blackjackStay(
        SessionInterface $session
    ): Response {
        /** @var CardHand $houseDeck */
        $houseDeck = $session->get("houseDeck");
        /** @var CardHand $boardDeck */
        $boardDeck = $session->get("boardDeck");

        $housePoints = $session->get("housePoints");
        /** @var bool $isSet */
        $isSet = $session->get("isSet");

        if ($housePoints < 21) {
            if ($isSet === true) {
                $draw = $boardDeck->draw();

                if ($draw !== null) {
                    $houseDeck->add($draw);
                }
            }
            $session->set("boardDeck", $boardDeck);
            $session->set("houseDeck", $houseDeck);
            $session->set("reveal", true);
        }

        $session->set("isSet", true);

        return $this->redirectToRoute('blackjack_start');
    }
}
