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
}
