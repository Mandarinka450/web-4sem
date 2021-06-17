<?php

declare(strict_types=1);

namespace App\Api\Books\Dto;

class BooksListResponseDto
{
    public array $data;

    public function __construct(BooksResponseDto ... $data)
    {
        $this->data = $data;
    }
}