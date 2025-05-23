<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryApiController extends AbstractController
{
    #[Route('api/library/books', name: 'library_api_books')]
    public function apiManyBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $data = [];

        foreach ($books as $book) {
            $data[] = [
                "title" => $book->getTitle(),
                "author" => $book->getAuthor(),
                "isbn" => $book->getISBN(),
                "image" => $book->getImage(),
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('api/library/book/{isbn}', name: 'api_library_read_one')]
    public function apiOneBook(
        BookRepository $bookRepository,
        int $isbn
    ): Response {
        $books = $bookRepository
            ->findAll();

        $data = [];

        foreach ($books as $book) {
            if ($book->getISBN() == $isbn) {
                $data[] = [
                    "title" => $book->getTitle(),
                    "author" => $book->getAuthor(),
                    "isbn" => $book->getISBN(),
                    "image" => $book->getImage(),
                ];
            }
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    // Route for twig file
    #[Route('api/library/search_isbn', name: 'api_library_read_one_twig', methods: ["POST"])]
    public function apiOneBookTwig(
        BookRepository $bookRepository,
        Request $request
    ): Response {
        $isbn = $request->request->get("isbn");

        $books = $bookRepository
            ->findAll();

        $data = [];

        foreach ($books as $book) {
            if ($book->getISBN() == $isbn) {
                $data[] = [
                    "title" => $book->getTitle(),
                    "author" => $book->getAuthor(),
                    "isbn" => $book->getISBN(),
                    "image" => $book->getImage(),
                ];
            }
        }

        if (empty($data)) {
            $response = new JsonResponse(
                ['error' => 'Youve entered an ISBN which is not in the database!'],
            );
        } else {
            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
        }

        return $response;
    }
}
