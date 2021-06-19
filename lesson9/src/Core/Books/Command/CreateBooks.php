<?php

declare(strict_types=1);

namespace App\Core\Books\Command;

use App\Core\Books\Document\Books;
use App\Core\Books\Repository\BooksRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateBooks extends Command
{
    protected static $defaultName = 'app:core:create-books';

    private BooksRepository $booksRepository;

    public function __construct(BooksRepository $booksRepository)
    {
        parent::__construct();

        $this->booksRepository = $booksRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new books.')
            ->setHelp('This command allows you to create a books...')
            ->addOption('author', null, InputOption::VALUE_REQUIRED, 'Author')
            ->addOption('title', null, InputOption::VALUE_REQUIRED, 'Title')
            ->addOption('desc', null, InputOption::VALUE_REQUIRED, 'Description');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($books = $this->booksRepository->findOneBy(['desc' => $input->getOption('desc')])) {
            $output->writeln(
                [
                    'Books already exists!',
                    '============',
                    $this->formatBooksLine($books),
                ]
            );

            return Command::SUCCESS;
        }

        $books = new Books(
            $input->getOption('author'),
            $input->getOption('title'),
            $input->getOption('desc')
        );
        $books->setAuthor($input->getOption('author'));
        $books->setTitle($input->getOption('title'));
        $books->setDesc($input->getOption('desc'));

        $this->booksRepository->save($books);

        $output->writeln(
            [
                'Books is created!',
                '============',
                $this->formatBooksLine($books),
            ]
        );

        return Command::SUCCESS;
    }

    private function formatBooksLine(Books $books): string
    {
        return sprintf(
            'id: %s, author: %s, title: %s, desc: %s',
            $books->getId(),
            $books->getAuthor(),
            $books->getTitle(),
            $books->getDesc(),
        );
    }
}