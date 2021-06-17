<?php

declare(strict_types=1);

namespace App\Core\Books\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Books\Repository\PublishRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=PublishRepository::class, collection="publishes")
 */
class Publish extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\UniqueIndex(name="edition")
     */
    protected string $edition;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $name;

    /**
     * @ReferenceOne(targetDocument=Books::class)
     */
    protected Books $books;

    public function __construct(string $edition, string $name, Books $books)
    {
        $this->edition = $edition;
        $this->name  = $name;
        $this->books  = $books;
    }

    public function getEdition(): string
    {
        return $this->edition;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBooks(): Books
    {
        return $this->books;
    }
}
