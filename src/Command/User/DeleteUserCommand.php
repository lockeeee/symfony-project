<?php


namespace App\Command\User;


use App\Model\User;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteUserCommand extends Command
{

    /**
     * @var UserService
     */
    private $userService;

    public function configure()
    {
        $this->setName('app:user:delete');
    }

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

            $helper = $this->getHelper('question');
            $idQuestion = new Question('Podaj numer uzytkownika, ktorego chcesz usunac: ');
            $id = $helper->ask($input, $output, $idQuestion);

            $this->userService->deleteUser($id);
            $io->success('Usunieto uzytkownika!');

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

        } catch(\Exception $exception) {
            $io->error($exception->getMessage());
        }
    }

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }
}