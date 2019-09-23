<?php


namespace App\Service;


use App\Model\RegisteredUser;
use App\Repository\RegisteredUserRepository;
use App\Validator\RegisteredUserValidator;

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

    public function  __construct(RegisteredUserValidator $registeredUserValidator, RegisteredUserRepository $registeredUserRepository)
    {
        $this->registeredUserValidator = $registeredUserValidator;
        $this->registeredUserRepository = $registeredUserRepository;
    }

    public function userRegistration(RegisteredUser $registeredUser) {

        $this->registeredUserValidator->validate($registeredUser);
        $this->registeredUserRepository->create($registeredUser);
    }

}