<?php

declare(strict_types=1);

namespace App\Core\Books\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Books\Document\Books;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Books save(Books $books)
 * @method Books|null find(string $id)
 * @method Books|null findOneBy(array $criteria)
 * @method Books getOne(string $id)
 */
class BooksRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Books::class;
    }

    /**
     * @throws LockException
     * @throws MappingException
     */
    public function getBooksById(string $id): ?Books
    {
        return $this->find($id);
    }
}