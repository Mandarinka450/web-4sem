<?php

declare(strict_types=1);

namespace App\Core\Books\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Books\Repository\BooksRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=BooksRepository::class, collection="books")
 */
class Books extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $author = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $title = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $desc = null;


    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDesc(): ?string
    {
        return $this->desc;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setDesc(?string $desc): void
    {
        $this->desc = $desc;
    }
}