<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Proj\GameHandler;
use App\Proj\RoomHandler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProjectController extends AbstractController
{
    #[Route("/proj", name: "project")]
    public function home(): Response
    {
        return $this->render('proj/proj.html.twig');
    }

    #[Route("/proj/about", name: "project_about")]
    public function projAbout(): Response
    {
        return $this->render('proj/proj.about.html.twig');
    }

    #[Route("/proj/game", name: "project_init")]
    public function game(
        SessionInterface $session
    ): Response {
        $roomName = $session->get("room");
        $room = is_string($roomName) ? $roomName : "bedroom";

        $handler = new RoomHandler();
        $currRoom = $handler->roomName($room);

        $data = [
            "room" => $currRoom->name,
            "desc" => $currRoom->desc,
            "image" => $currRoom->image
        ];

        return $this->render('proj/proj_game.html.twig', [
            'data' => $data
        ]);
    }

    #[Route("/proj/game/reset", name: "project_init_reset")]
    public function gameReset(
        SessionInterface $session
    ): Response {
        $session->set("room", "bedroom");
        $session->set("inventory", []);

        $handler = new RoomHandler();
        $currRoom = $handler->roomName("bedroom");

        $data = [
            "room" => $currRoom->name,
            "desc" => $currRoom->desc,
            "image" => $currRoom->image
        ];

        return $this->render('proj/proj_game.html.twig', [
            'data' => $data
        ]);
    }

    #[Route("/proj/game/room", name: "project_handle_room_change", methods: ["POST"])]
    public function change(
        SessionInterface $session,
        Request $request
    ): Response {
        $roomValue = $session->get("room");
        $room = is_string($roomValue) ? $roomValue : "bedroom";

        /** @var array<string> $inventory contains player inventory */
        $inventory = (array) ($session->get("inventory") ?? []);

        $action = (string) ($request->request->get('action'));

        $roomHandler = new GameHandler();

        $res = $roomHandler->action($room, $action, $inventory);

        if (isset($res["add"]) && !in_array($res["add"], $inventory)) {
            $inventory[] = $res["add"];
            $session->set("inventory", $inventory);
        }

        $data = [
            "room" => $res["room"],
            "desc" => $res["msg"],
            "image" => $res["image"]
        ];

        $session->set("room", $res["room"]);

        return $this->render('proj/proj_game.html.twig', [
            'data' => $data,
        ]);
    }
}
