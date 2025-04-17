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

    #[Route("/card/roll", name: "roll_card")]
    public function testRollCard(): Response
    {
        $card = new Card("KDr");

        $data = [
            "card" => $card->cardToUnicode(),
        ];

        return $this->render('card/test/roll.html.twig', $data);
    }

    #[Route("/card/deck", name: "deck_card")]
    public function showDeck(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $userDeck = $session->get("userDeck") ?? [];

        if (count($userDeck) === 52 && $deck === []) {
            $cardCount = count($deck);

            $data = [
                'deck' => $deck,
                "cardsLeft" => $cardCount,
                "userDeck" => $userDeck,
            ];

        } elseif ($deck == null) {
            $deck = Card::wholeDeck();
            $userDeck = [];
            $cardCount = count($deck);

            $data = [
                'deck' => $deck,
                "cardsLeft" => $cardCount,
                "userDeck" => $userDeck,
            ];

            $session->set("deck", $deck);
        } else {
            $data = [
                'deck' => $deck,
                "cardsLeft" => 0,
                "userDeck" => $userDeck,
            ];
        }

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "deck_card_shuffle")]
    public function shuffledDeck(
        SessionInterface $session
    ): Response {
        $deck = Card::shuffleDeck();

        $session->set("deck", $deck);
        $session->set("userDeck", []);

        $data = [
            "deck" => $deck,
            "bool" => "",
            "userDeck" => $session->get("userDeck"),
        ];

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "deck_card_draw")]
    public function drawFromDeck(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $userDeck = $session->get("userDeck") ?? [];

        if (empty($deck)) {
            $this->addFlash(
                'warning',
                'There are no cards left in the deck!'
            );

            $data = [
                "draw" => "",
                "bool" => "",
                "userDeck" => $userDeck,
            ];
        } else {
            $currCard = array_shift($deck);

            array_push($userDeck, $currCard);

            $currCardUnicode = $currCard->cardToUnicode();

            $data = [
                "draw" => $currCardUnicode,
                "bool" => "",
                "userDeck" => $userDeck,
            ];

            $session->set("deck", $deck);
            $session->set("userDeck", $userDeck);
        }

        return $this->render('card/test/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/:{num<\d+>}", name: "deck_card_draw_num_get", methods: ['GET'])]
    public function drawNumFromDeckGet(
        SessionInterface $session,
        int $num
    ): Response {
        $deck = $session->get("deck");
        $userDeck = $session->get("userDeck") ?? [];
        $isDeckArray = false;

        if (empty($deck) || !(is_array($deck))) {
            $this->addFlash(
                'warning',
                'There are no cards left in the deck!'
            );
            return $this->redirectToRoute('deck_card');
        }

        if (count($deck) < $num) {
            $this->addFlash(
                'warning',
                "You can't draw more cards than there are in the deck!"
            );
            return $this->redirectToRoute('deck_card');
        }

        $showCard = [];
        $isDeckArray = true;

        for ($i = 0; $i < $num; $i++) {
            if (empty($deck)) {
                break;
            }

            $card = array_shift($deck);

            $showCard[] = $card;
            $userDeck[] = $card;
        }

        $session->set("deck", $deck);
        $session->set("userDeck", $userDeck);

        $data = [
            "draw" => $showCard,
            "bool" => $isDeckArray,
            "userDeck" => $userDeck,
            "num" => $num,
        ];

        return $this->render('card/test/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/page", name: "deck_card_draw_num", methods: ['POST'])]
    public function drawNumFromDeck(
        SessionInterface $session,
        Request $request
    ): Response {
        $num = $request->request->get('num');
        $deck = $session->get("deck");
        $userDeck = $session->get("userDeck") ?? [];
        $isDeckArray = false;

        if (empty($deck) || !(is_array($deck))) {
            $this->addFlash(
                'warning',
                'There are no cards left in the deck!'
            );
            return $this->redirectToRoute('deck_card');
        }

        if (count($deck) < $num) {
            $this->addFlash(
                'warning',
                "You can't draw more cards than there are in the deck!"
            );
            return $this->redirectToRoute('deck_card');
        }

        $showCard = [];
        $isDeckArray = true;

        for ($i = 0; $i < $num; $i++) {
            if (empty($deck)) {
                break;
            }

            $card = array_shift($deck);

            $showCard[] = $card;
            $userDeck[] = $card;
        }

        $session->set("deck", $deck);
        $session->set("userDeck", $userDeck);

        $data = [
            "draw" => $showCard,
            "bool" => $isDeckArray,
            "userDeck" => $userDeck,
        ];

        return $this->render('card/test/draw.html.twig', $data);
    }

    #[Route("/game/pig/test/roll/{num<\d+>}", name: "test_roll_num_dices")]
    public function testRollDices(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $diceRoll = [];
        for ($i = 1; $i <= $num; $i++) {
            // $die = new Dice();
            $die = new DiceGraphic();
            $die->roll();
            $diceRoll[] = $die->getAsString();
        }

        $data = [
            "num_dices" => count($diceRoll),
            "diceRoll" => $diceRoll,
        ];

        return $this->render('pig/test/roll_many.html.twig', $data);
    }

    #[Route("/game/pig/test/dicehand/{num<\d+>}", name: "test_dicehand")]
    public function testDiceHand(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new DiceGraphic());
            } else {
                $hand->add(new Dice());
            }
        }

        $hand->roll();

        $data = [
            "num_dices" => $hand->getNumberDices(),
            "diceRoll" => $hand->getString(),
        ];

        return $this->render('pig/test/dicehand.html.twig', $data);
    }

    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }

    // #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    // public function initCallback(): Response
    // {
    //     // Deal with the submitted form

    //     return $this->redirectToRoute('pig_play');
    // }

    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $numDice = $request->request->get('num_dices');

        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        $hand->roll();

        $session->set("pig_dicehand", $hand);
        $session->set("pig_dices", $numDice);
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);

        return $this->redirectToRoute('pig_play');
    }

    // #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    // public function play(): Response
    // {
    //     // Logic to play the game

    //     return $this->render('pig/play.html.twig');
    // }

    // #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    // public function play(
    //     SessionInterface $session
    // ): Response
    // {
    //     $data = [
    //         "pigDices" => $session->get("pig_dices"),
    //         "pigRound" => $session->get("pig_round"),
    //         "pigTotal" => $session->get("pig_total"),
    //     ];

    //     return $this->render('pig/play.html.twig', $data);
    // }

    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {
        $dicehand = $session->get("pig_dicehand");

        $data = [
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString()
        ];

        return $this->render('pig/play.html.twig', $data);
    }

    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response {
        $hand = $session->get("pig_dicehand");
        $hand->roll();

        $roundTotal = $session->get("pig_round");
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;

                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );

                break;
            }
            $round += $value;
        }

        $session->set("pig_round", $roundTotal + $round);

        return $this->redirectToRoute('pig_play');
    }

    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        $session->set("pig_round", 0);
        $session->set("pig_total", $roundTotal + $gameTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('pig_play');
    }
}
