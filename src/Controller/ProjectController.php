<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Room;
use App\Proj\Projer;
use App\Proj\RoomHandler;
use App\Repository\RoomRepository;
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

    #[Route("/proj/game", name: "project_init")]
    public function game(
        SessionInterface $session
    ): Response
    {
        $room = $session->set("room", "bedroom");
        $inventory = $session->set("inventory", []);

        $handler = new RoomHandler();
        $test = $handler->roomName("Bedroom");

        $data = [
            "room" => $test->name,
            "desc" => $test->desc,
            "image" => $test->image
        ];

        return $this->render('proj/proj_game.html.twig', [
            'data' => $data
        ]);
    }

    #[Route("/proj/game/room", name: "project_handle_room_change")]
    public function change(
        SessionInterface $session,
        Request $request
    ): Response {
        $room = $session->get("room") ?? "bedroom";
        $inventory = $session->get("inventory") ?? [];

        $action = (string) $request->request->get('action');

        $roomHandler = new Projer();

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
