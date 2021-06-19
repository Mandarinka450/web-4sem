<?php

declare(strict_types=1);

namespace App\Api\Books\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ValidationExampleRequestDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(30)
     */
    public string $author;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(50)
     */
    public string $title;

    /**
     * @Assert\NotBlank()
     */
    public string $desc;
}