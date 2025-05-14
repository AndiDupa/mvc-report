<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route("/library/create", name: "library_create_post", methods: ['POST'])]
    public function createBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $title = (string) $request->request->get('title');
        $author = (string) $request->request->get('author');
        $isbn = (string) $request->request->get('ISBN');
        $image = (string) $request->request->get('image');

        $book = new Book();

        $entityManager = $doctrine->getManager();

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setISBN($isbn);
        $book->setImage($image);

        $entityManager->persist($book);

        $entityManager->flush();

        // return new Response('Saved new product with id '.$book->getId());
        return $this->redirectToRoute('library_read_many');
    }

    #[Route('/library/read_many', name: 'library_read_many')]
    public function readManyBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $data = [
            "books" => $books,
        ];

        // foreach($books as $book) {
        //     echo($book->getTitle());
        // }

        return $this->render('library/read.html.twig', $data);
    }

    #[Route('/library/read_one/{id}', name: 'library_read_one')]
    public function readOneBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $books = $bookRepository
            ->find($id);

        $book = [
            $books
        ];

        $data = [
            "books" => $book,
        ];

        return $this->render('library/read.html.twig', $data);
    }

    #[Route('/library/update_edit', name: 'library_update_landing', methods: ['POST'])]
    public function updateBookLanding(
        BookRepository $bookRepository,
        Request $request
    ): Response {
        $id = (int) $request->request->get("book_id");

        $books = $bookRepository
        ->find($id);

        $book = [
            $books
        ];

        $data = [
            "books" => $book,
        ];

        return $this->render('library/update.html.twig', $data);
    }

    #[Route('/library/update', name: 'library_update', methods: ['POST'])]
    public function updateBook(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $id = (int) $request->request->get("book_id");

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $title = (string) $request->request->get('title');
        $author = (string) $request->request->get('author');
        $isbn = (string) $request->request->get('isbn');
        $image = (string) $request->request->get('image');

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setISBN($isbn);
        $book->setImage($image);

        $entityManager->flush();

        return $this->redirectToRoute('library_read_many');
    }

    #[Route('/library/delete', name: 'library_delete_by_id', methods: ["POST"])]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $id = (int) $request->request->get("book_id");

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_read_many');
    }
}
