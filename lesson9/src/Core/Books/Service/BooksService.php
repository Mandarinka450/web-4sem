<?php

declare(strict_types=1);

namespace App\Core\Books\Service;

use App\Api\Books\Dto\BooksCreateRequestDto;
use App\Api\Books\Dto\BooksUpdateRequestDto;
use App\Core\Books\Document\Books;
use App\Core\Books\Factory\BooksFactory;
use App\Core\Books\Repository\BooksRepository;
use Psr\Log\LoggerInterface;

class BooksService
{
    /**
     * @var BooksRepository
     */
    private BooksRepository $booksRepository;

    /**
     * @var BooksFactory
     */
    private BooksFactory $booksFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(BooksRepository $booksRepository, BooksFactory $booksFactory, LoggerInterface $logger)
    {
        $this->booksRepository = $booksRepository;
        $this->booksFactory    = $booksFactory;
        $this->logger         = $logger;
    }

    public function findOneBy(array $criteria): ?Books
    {
        return $this->booksRepository->findOneBy($criteria);
    }

    public function updateBooks(string $id, BooksUpdateRequestDto $requestDto)
    {
        //todo update logic
    }

    public function createBooks(BooksCreateRequestDto $requestDto): Books
    {
        $books = $this->booksFactory->create(
            $requestDto->author,
            $requestDto->title,
            $requestDto->desc
        );

        $books->setAuthor($requestDto->author);
        $books->setTitle($requestDto->title);
        $books->setDesc($requestDto->desc);

        $books = $this->booksRepository->save($books);

        $this->logger->info('Books created successfully', [
            'books_id' => $books->getId(),
            'title' => $books->getTitle(),
        ]);

        return $books;
    }
}