<?php

declare(strict_types=1);

namespace App\Api\Books\Controller;

use App\Api\Books\Dto\BooksCreateRequestDto;
use App\Api\Books\Dto\BooksListResponseDto;
use App\Api\Books\Dto\BooksResponseDto;
use App\Api\Books\Dto\BooksUpdateRequestDto;
use App\Api\Books\Dto\ValidationExampleRequestDto;
use App\Api\Books\Factory\ResponseFactory;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Common\Factory\HTTPResponseFactory;
use App\Core\User\Document\Contact;
use App\Core\Books\Document\Books;
use App\Core\Books\Enum\PermissionBooks;
use App\Core\User\Repository\ContactRepository;
use App\Core\Books\Repository\BooksRepository;
use App\Core\Books\Service\BooksService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/books")
 */
class BooksController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(PermissionBooks::BOOKS_SHOW)
     *
     * @ParamConverter("books")
     *
     * @Rest\View()
     *
     * @param Books|null         $books
     * @param ResponseFactory   $responseFactory
     *
     * @return BooksResponseDto
     */
    public function show(Books $books = null, ResponseFactory $responseFactory)
    {
        if (!$books) {
            throw $this->createNotFoundException('Book not found');
        }

        return $responseFactory->createBooksResponse($books);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(PermissionBooks::BOOKS_INDEX)
     * @Rest\View()
     *
     * @param Request         $request
     * @param BooksRepository  $booksRepository
     * @param ResponseFactory $responseFactory
     *
     * @return BooksListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        BooksRepository $booksRepository,
        ResponseFactory $responseFactory
    ): BooksListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $books = $booksRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new BooksListResponseDto(
            ... array_map(
                    function (Books $books) use ($responseFactory) {
                        return $responseFactory->createBooksResponse($books);
                    },
                    $books
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(PermissionBooks::BOOKS_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param BooksCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param BooksService                      $service
     * @param ResponseFactory                  $responseFactory
     * @param HTTPResponseFactory              $HTTPResponseFactory
     *
     * @return BooksResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        BooksCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BooksService $service,
        ResponseFactory $responseFactory,
        HTTPResponseFactory $HTTPResponseFactory
    ) {
        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createBooksResponse($service->createBooks($requestDto));
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(PermissionBooks::BOOKS_UPDATE)
     * @ParamConverter("books")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param Books|null                        $books
     * @param BooksUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param BooksRepository                   $booksRepository
     * @param ResponseFactory                  $responseFactory
     *
     * @return BooksResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Books $books = null,
        BooksUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BooksRepository $booksRepository,
        ResponseFactory $responseFactory
    ) {
        if (!$books) {
            throw $this->createNotFoundException('Books not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $books->setAuthor($requestDto->author);
        $books->setTitle($requestDto->title);
        $books->setDesc($requestDto->desc);

        $booksRepository->save($books);

        return $responseFactory->createBooksResponse($books);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(PermissionBooks::BOOKS_DELETE)
     * @ParamConverter("books")
     *
     * @Rest\View()
     *
     * @param Books|null      $books
     * @param BooksRepository $booksRepository
     *
     * @return BooksResponseDto|ValidationFailedResponse
     */
    public function delete(
        BooksRepository $booksRepository,
        Books $books = null
    ) {
        if (!$books) {
            throw $this->createNotFoundException('Book not found');
        }

        $booksRepository->remove($books);
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(PermissionBooks::BOOKS_VALIDATION)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @return ValidationExampleRequestDto|ValidationFailedResponse
     */
    public function validation(
        ValidationExampleRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $requestDto;
    }
}