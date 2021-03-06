<?php

namespace App\Command\User;

use App\Model\User;
use App\Service\UserService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowUserCommand extends Command
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
        $this->setName('app:user:show');
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
            $rows = [];

            /** @var User $showUser */
            foreach ($this->userService->showUsers() as $showUser) {
                $rows[] = [
                    $showUser->getId(),
                    $showUser->getName(),
                    $showUser->getSurname(),
                    $showUser->getMail(),
                    $showUser->getPnumber()
                ];
            }
            $table = new Table($output);
            $table
                ->setHeaders(['Nr', 'Imie', 'Nazwisko', 'Mail', 'Telefon'])
                ->setRows($rows)
                ->render();
        } catch (Exception $exception) {
            $io->error($exception->getMessage());
        }
    }
}