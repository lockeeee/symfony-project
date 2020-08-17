<?php

namespace App\Service;

use App\Model\RegisteredUser;
use App\Repository\RegisteredUserRepository;
use App\Validator\RegisteredUserValidator;
use Doctrine\DBAL\DBALException;

class RegisteredUserService
{
    /**
     * @var RegisteredUserValidator
     */
    private $registeredUserValidator;

    /**
     * @var RegisteredUserRepository
     */
    private $registeredUserRepository;

    /**
     * @param RegisteredUserValidator  $registeredUserValidator
     * @param RegisteredUserRepository $registeredUserRepository
     */
    public function  __construct(
        RegisteredUserValidator $registeredUserValidator,
        RegisteredUserRepository $registeredUserRepository
    ) {
        $this->registeredUserValidator = $registeredUserValidator;
        $this->registeredUserRepository = $registeredUserRepository;
    }

    /**
     * @param RegisteredUser $registeredUser
     *
     * @throws DBALException
     */
    public function userRegistration(RegisteredUser $registeredUser)
    {
        $this->registeredUserValidator->validate($registeredUser);
        $this->registeredUserRepository->create($registeredUser);
    }
}