<?php

namespace App\Validator;

use App\Model\RegisteredUser;
use Exception;

class RegisteredUserValidator
{
    /**
     * @param RegisteredUser $registeredUser
     *
     * @throws Exception
     */
    public function validate(RegisteredUser $registeredUser)
    {
        if (empty($registeredUser->getName())) {
            throw new Exception("Proszę podać imię!");
        }

        if (empty($registeredUser->getSurname())) {
            throw new Exception("Proszę podać nazwisko!");
        }

        if (empty($registeredUser->getMail())) {
            throw new Exception("Proszę podać maila!");
        }

        if (empty($registeredUser->getLogin())) {
            throw new Exception("Proszę podać login!");
        }

        if (empty($registeredUser->getPassword())) {
            throw new Exception("Proszę podać hasło!");
        }
    }
}