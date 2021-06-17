<?php

declare(strict_types=1);

namespace App\Api\Books\Dto;

class PublishResponseDto
{
    public ?string $id = null;

    public string $edition;

    public string $name;
}