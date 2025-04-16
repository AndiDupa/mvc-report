<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Session extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {

        $sessionData = $session->all();

        $data = [
            "session" => $sessionData,
        ];

        return $this->render('session.twig', $data);
    }

    #[Route("/session/delete", name: "sessiondelete")]
    public function sessiondelete(
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
