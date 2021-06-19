<?php

declare(strict_types=1);

namespace App\Api\Books\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BooksUpdateRequestDto
{
    /**
     * @Assert\Length(max=100, min=10)
     */
    public ?string $author = null;
    
    public ?string $title = null;

    public ?string $desc = null;
}