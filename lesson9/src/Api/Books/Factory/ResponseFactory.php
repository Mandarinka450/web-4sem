<?php

declare(strict_types=1);

namespace App\Api\Books\Factory;

use App\Api\User\Dto\ContactResponseDto;
use App\Api\Books\Dto\BooksResponseDto;
use App\Core\Books\Document\Books;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @param Books         $books
     *
     * @return BooksResponseDto
     */
    public function createBooksResponse(Books $books): BooksResponseDto
    {
        $dto = new BooksResponseDto();

        $dto->id                = $books->getId();
        $dto->author                = $books->getAuthor();
        $dto->title         = $books->getTitle();
        $dto->desc         = $books->getDesc();

        return $dto;
    }
}