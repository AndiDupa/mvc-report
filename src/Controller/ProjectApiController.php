<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Proj\GameHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Proj\RoomHandler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProjectApiController extends AbstractController
{
    #[Route("/proj/api", name: "project_json")]
    public function projJson(): Response
    {
        return $this->render('proj/proj.json.html.twig');
    }

    #[Route("/proj/api/all_rooms", name: "project_json_all_rooms")]
    public function projJsonAllRooms(): Response
    {
        $handler = new RoomHandler();

        $response = new JsonResponse($handler->getRooms());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/proj/api/search", name: "project_json_search", methods: ["POST"])]
    public function projJsonSearch(
        Request $request
    ): Response {
        $search = strtolower((string) $request->request->get("room"));
        $handler = new RoomHandler();
        $data = [];

        foreach ($handler->getRooms() as $key => $value) {
            if ($search === $key) {
                $data[] = $value;
            }
        }

        if ($data === []) {
            $data[] = "No room found matching your search.";
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/proj/api/session", name: "project_json_session")]
    public function projJsonSession(
        SessionInterface $session
    ): Response {
        /** @var string $room contains room name */
        $room = $session->get("room");

        /** @var array<string> $inventory contains player inventory */
        $inventory = $session->get("inventory");

        $data = [];
        $data[] = [
            $room,
            $inventory
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/proj/api/reset", name: "project_json_reset")]
    public function projJsonAllItems(
        SessionInterface $session
    ): Response {
        $session->set("room", "bedroom");
        $session->set("inventory", []);

        /** @var string $room contains room name */
        $room = $session->get("room");

        /** @var array<string> $inventory contains player inventory */
        $inventory = $session->get("inventory");

        $data = [];
        $data[] = [
            "The session has been reset to it's original values.",
            $room,
            $inventory
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/proj/api/set", name: "project_json_set", methods: ["POST"])]
    public function projJsonSet(
        Request $request,
        SessionInterface $session
    ): Response {
        $room = strtolower((string) $request->request->get("room"));
        $inventory = strtolower((string) $request->request->get("inventory"));

        $data = [];

        if ($inventory === "" || $room === "") {
            $response = new JsonResponse("Vänligen fyll i båda fälten");
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        } else {
            $arrInventory = explode(", ", $inventory);

            $session->set("room", $room);
            $session->set("inventory", $arrInventory);
        }

        $data[] = [
            $room,
            $inventory
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
