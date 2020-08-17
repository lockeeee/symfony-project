<?php

namespace App\Command\User;

use App\Model\User;
use App\Service\UserService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateUserCommand extends Command
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * @inheritDoc
     */
    public function configure()
    {
        $this->setName('app:user:create');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $helper = $this->getHelper('question');
            $nameQuestion = new Question('Podaj imie: ');
            $surnameQuestion = new Question('Podaj nazwisko: ');
            $mailQuestion = new Question('Podaj maila: ');
            $pnumberQuestion = new Question('Podaj numer telefonu: ');

            $user = new User(
                NULL,
                $helper->ask($input, $output, $nameQuestion),
                $helper->ask($input, $output, $surnameQuestion),
                $helper->ask($input, $output, $mailQuestion),
                $helper->ask($input, $output, $pnumberQuestion)
            );
            $this->userService->createUser($user);
            $io->success('Dodano uzytkownika!');
        } catch(Exception $exception) {
            $io->error($exception->getMessage());
        }
    }
}