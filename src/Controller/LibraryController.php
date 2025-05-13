<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Books;
use App\Repository\BooksRepository;
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
        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('ISBN');
        $image = $request->request->get('image');

        $book = new Books();

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
        BooksRepository $booksRepository
    ): Response {
        $books = $booksRepository
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
        BooksRepository $booksRepository,
        int $id
    ): Response {
        $books = $booksRepository
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
        ManagerRegistry $doctrine,
        BooksRepository $booksRepository,
        Request $request
    ): Response {
        $id = $request->request->get("book_id");

        $books = $booksRepository
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
        $id = $request->request->get("book_id");

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');
        $image = $request->request->get('image');

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
        $id = $request->request->get("book_id");

        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);

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
