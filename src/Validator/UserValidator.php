<?php

namespace App\Validator;

use App\Model\User;
use Exception;

class UserValidator
{
    /**
     * @param User $user
     *
     * @throws Exception
     */
    public function validate(User $user)
    {
        if (empty($user->getName())) {
            throw new Exception("Prosze podac imie!");
        }

        if (empty($user->getSurname())) {
            throw new Exception("Prosze podac nazwisko!");
        }

        if (empty($user->getMail())) {
            throw new Exception("Prosze podac maila!");
        }

        if (empty($user->getPnumber())) {
            throw new Exception("Prosze podac numer telefonu!");
        }
    }
}