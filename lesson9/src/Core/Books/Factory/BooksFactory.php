<?php

declare(strict_types=1);

namespace App\Core\Books\Factory;

use App\Core\Books\Document\Books;

class BooksFactory
{
    public function create(
        string $author,
        string $title,
        string $desc
    ): Books {
        $books = new Books(
            $author,
            $title,
            $desc
        );

        return $books;
    }
}