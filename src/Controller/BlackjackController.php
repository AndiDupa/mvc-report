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
    #[Route("/blackjack", name: "blackjack")]
    public function home(): Response
    {
        return $this->render('card/blackjack.html.twig');
    }

    #[Route("/blackjack/result", name: "blackjack_result")]
    public function result(): Response
    {
        return $this->render('card/blackjack_result.html.twig');
    }

    #[Route("/blackjack/start", name: "blackjack_start")]
    public function blackjackStart(
        SessionInterface $session
    ): Response {
        $houseDeck = $session->get("houseDeck") ?? new CardHand();
        $playerDeck = $session->get("playerDeck") ?? new CardHand();
        $boardDeck = $session->get("boardDeck") ?? new CardHand();

        $housePoints = $session->get("housePoints") ?? 0;
        $playerPoints = $session->get("playerPoints") ?? 0;

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

        $playerScoreArr = $playerDeck->cardHand();
        $houseScoreArr = $houseDeck->cardHand();

        $playerScore = CardGame::temper($playerScoreArr);
        $houseScore = CardGame::temper($houseScoreArr);

        $session->set("housePoints", $houseScore);
        $session->set("playerPoints", $playerScore);

        if ($playerScore > 21) {
            $this->addFlash(
                'warning',
                "Bust! You lose with the hand $playerScore."
            );
            return $this->redirectToRoute('blackjack_result');
        }

        if ($houseScore === 21) {
            $this->addFlash(
                'warning',
                "You lose! The house got $houseScore."
            );
            return $this->redirectToRoute('blackjack_result');
        }

        if ($houseScore > 21) {
            echo("HELLOOOOOOO");
            $this->addFlash(
                'success',
                "You win! The house bust with $houseScore."
            );
            return $this->redirectToRoute('blackjack_result');
        }

        $data = [
            "houseDeck" => $houseDeck->cardHand(),
            "playerDeck" => $playerDeck->cardHand(),
            "housePoints" => $houseScore,
            "playerPoints" => $playerScore,
        ];

        return $this->render('card/blackjack_game.html.twig', $data);
    }

    #[Route("/blackjack/call", name: "blackjack_call", methods: ["GET"])]
    public function blackjackCall(
        SessionInterface $session
    ): Response {
        $playerDeck = $session->get("playerDeck");
        $boardDeck = $session->get("boardDeck");

        $playerDeck->add($boardDeck->draw());

        $session->set("boardDeck", $boardDeck);
        $session->set("playerDeck", $playerDeck);

        return $this->redirectToRoute('blackjack_start');
    }

    #[Route("/blackjack/stay", name: "blackjack_stay", methods: ["GET"])]
    public function blackjackStay(
        SessionInterface $session
    ): Response {
        $houseDeck = $session->get("houseDeck");
        $boardDeck = $session->get("boardDeck");

        $housePoints = $session->get("housePoints");

        if ($housePoints < 21) {
            $houseDeck->add($boardDeck->draw());
            $session->set("boardDeck", $boardDeck);
            $session->set("houseDeck", $houseDeck);
        }

        return $this->redirectToRoute('blackjack_start');
    }
}
