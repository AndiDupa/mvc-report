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

class HomeRoute extends AbstractController
{
    #[Route('/', name: "Home")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            "number" => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/metrics", name: "metrics")]
    public function metrics(): Response
    {
        return $this->render('metrics/metrics.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);
        $date = date("Y/m/d");
        $coin = random_int(0, 1);
        $side = "krona";

        if ($coin === 1) {
            $side = "klave";
        }

        $data = [
            'number' => $number,
            'date' => $date,
            'side' => $side
        ];

        return $this->render('lucky.html.twig', $data);
    }
}
