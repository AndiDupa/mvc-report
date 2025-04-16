<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeRoute extends AbstractController
{
    #[Route('/', name: "Home")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            "number" => $number
        ];

        // return new Response(
        //     '
        //         <html>
        //             <body>
        //                 Mitt namn är Andi Dupa. <br> Lucky number: '.$number.'
        //             </body>
        //         </html>
        //     '
        // );

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

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}


// <?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

// class LuckyControllerTwig extends AbstractController
// {
//     #[Route("/lucky/number/twig", name: "lucky_number")]
//     public function number(): Response
//     {
//         $number = random_int(0, 100);

//         $data = [
//             'number' => $number
//         ];

//         return $this->render('lucky_number.html.twig', $data);
//     }

//     #[Route("/home", name: "home")]
//     public function home(): Response
//     {
//         return $this->render('home.html.twig');
//     }

//     #[Route("/about", name: "about")]
//     public function about(): Response
//     {
//         return $this->render('about.html.twig');
//     }
// }
