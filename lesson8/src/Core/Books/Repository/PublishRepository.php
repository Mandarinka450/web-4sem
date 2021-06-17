<?php

declare(strict_types=1);

namespace App\Core\Books\Repository;


use App\Core\Common\Repository\AbstractRepository;
use App\Core\Books\Document\Publish;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Publish save(Publish $books)
 * @method Publish|null find(string $id)
 * @method Publish|null findOneBy(array $criteria)
 * @method Publish getOne(string $id)
 */
class PublishRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Publish::class;
    }

    /**
     * @throws LockException
     * @throws MappingException|MappingException
     */
    public function getPublishById(string $id): ?Publish
    {
        return $this->find($id);
    }
}