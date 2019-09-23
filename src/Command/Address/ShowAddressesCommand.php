<?php


namespace App\Command\Address;

use App\Model\Address;
use App\Service\AddressService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowAddressesCommand extends Command
{

    /**
     * @var AddressService
     */
    private $addressService;

    public function configure()
    {
        $this->setName('app:address:show');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $rows = [];

            /** @var Address $showAddress */
            foreach ($this->addressService->showAddresses() as $showAddress) {
                $rows[] = [
                  $showAddress->getId(),
                  $showAddress->getUserId(),
                  $showAddress->getStreet(),
                  $showAddress->getPostnumber(),
                  $showAddress->getCity(),
                  $showAddress->getCountry()
                ];

            }

            $table = new Table($output);
            $table
                ->setHeaders(['Nr', 'Mieszkaniec', 'Ulica', 'Kod pocztowy', 'Miasto', 'Kraj'])
                ->setRows($rows)
                ->render();

        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
        }
    }

    public function __construct(AddressService $addressService)
    {
        parent::__construct();
        $this->addressService = $addressService;
    }

}

?>