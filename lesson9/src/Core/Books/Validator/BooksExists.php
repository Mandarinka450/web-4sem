<?php

declare(strict_types=1);

namespace App\Core\Books\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BooksExists extends Constraint
{
    public $message = 'Books already exists, id: {{ booksId }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}