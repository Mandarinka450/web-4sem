<?php

declare(strict_types=1);

namespace App\Core\Books\Validator;

use App\Core\Books\Repository\BooksRepository;
use App\Core\Books\Service\BooksService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class BooksExistsValidator extends ConstraintValidator
{
    /**
     * @var BooksService
     */
    private BooksService $booksService;

    public function __construct(BooksService $booksService)
    {
        $this->booksService = $booksService;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BooksExists) {
            throw new UnexpectedTypeException($constraint, BooksExists::class);
        }

        $books = $this->booksService->findOneBy(['id' => $value->id]);

        if ($books) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ booksId }}', $books->getId())
                ->addViolation();
        }
    }
}