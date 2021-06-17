<?php

declare(strict_types=1);

namespace App\Api\Books\Controller;

use App\Api\Books\Dto\PublishResponseDto;
use App\Api\Books\Dto\BooksCreateRequestDto;
use App\Api\Books\Dto\BooksListResponseDto;
use App\Api\Books\Dto\BooksResponseDto;
use App\Api\Books\Dto\BooksUpdateRequestDto;
use App\Api\Books\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Books\Document\Publish;
use App\Core\Books\Document\Books;
use App\Core\Books\Enum\PermissionBooks;
use App\Core\Books\Repository\PublishRepository;
use App\Core\Books\Repository\BooksRepository;
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
     * @param Books|null $books
     *
     * @return BooksResponseDto
     */
    public function show(Books $books = null, PublishRepository $publishRepository)
    {
        if (!$books) {
            throw $this->createNotFoundException('Ad not found');
        }

        $publish = $publishRepository->findOneBy(['books' => $books]);

        return $this->createBooksResponse($books, $publish);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(PermissionBooks::BOOKS_INDEX)
     * @Rest\View()
     *
     * @return BooksListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        BooksRepository $booksRepository
    ): BooksListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $books = $booksRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new BooksListResponseDto(
            ... array_map(
                    function (Books $books) {
                        return $this->createBooksResponse($books);
                    },
                    $books
                )
        );
    }

    /**
     * @Route(path="/", methods={"POST"})
     * @IsGranted(PermissionBooks::BOOKS_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param BooksCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param BooksRepository                   $booksRepository
     *
     * @return BooksResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        BooksCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BooksRepository $booksRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($books = $booksRepository->findOneBy(['title' => $requestDto->title])) {
            return new Response('Books already exists', Response::HTTP_BAD_REQUEST);
        }

        $books = new Books(
            $requestDto->author,
            $requestDto->title,
            $requestDto->desc
        );
        $books->setAuthor($requestDto->author);
        $books->setTitle($requestDto->title);
        $books->setDesc($requestDto->desc);

        $booksRepository->save($books);

        return $this->createBooksResponse($books);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}/publish", methods={"POST"})
     * @IsGranted(PermissionBooks::BOOKS_PUBLISH_CREATE)
     * @ParamConverter("books")
     *
     * @Rest\View(statusCode=201)
     *
     * @param Request           $request
     * @param Books|null         $books
     * @param PublishRepository $publishRepository
     *
     * @return BooksResponseDto|ValidationFailedResponse|Response
     */
    public function createPublish(
        Request $request,
        Books $books = null,
        PublishRepository $publishRepository
    ) {
        // todo проверки на валидацию всего всего и дто ...
        $publish = new Publish($request->get('edition', ''), $request->get('name', ''), $books);
        $publishRepository->save($publish);

        return $this->createBooksResponse($books, $publish);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(PermissionBooks::BOOKS_UPDATE)
     * @ParamConverter("books")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param BooksUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param BooksRepository                   $booksRepository
     *
     * @return BooksResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Books $books = null,
        BooksUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BooksRepository $booksRepository
    ) {
        if (!$books) {
            throw $this->createNotFoundException('Ad not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }
        
        $books->setAuthor($requestDto->author);
        $books->setTitle($requestDto->title);
        $books->setDesc($requestDto->desc);

        $booksRepository->save($books);

        return $this->createBooksResponse($books);
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
            throw $this->createNotFoundException('Ad not found');
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

    /**
     * @param Books         $books
     * @param Publish|null $publish
     *
     * @return BooksResponseDto
     */
    private function createBooksResponse(Books $books, ?Publish $publish = null): BooksResponseDto
    {
        $dto = new BooksResponseDto();

        $dto->id                = $books->getId();
        $dto->author        = $books->getAuthor();
        $dto->title        = $books->getTitle();
        $dto->desc          = $books->getDesc();

        if ($publish) {
            $publishResponseDto        = new PublishResponseDto();
            $publishResponseDto->id    = $publish->getId();
            $publishResponseDto->edition = $publish->getEdition();
            $publishResponseDto->name  = $publish->getName();

            $dto->publish = $publishResponseDto;
        }

        return $dto;
    }

}