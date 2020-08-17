<?php

namespace App\Validator;

use App\Model\Address;
use Exception;

class AddressValidator
{
    /**
     * @param Address $address
     *
     * @throws Exception
     */
    public function validate(Address $address)
    {
        if ($address->getUserId() == 'Wybierz...') {
            throw new Exception("Wskaz mieszkanca!");
        }

        if (empty($address->getStreet())) {
            throw new Exception("Prosze wspisac ulice!");
        }

        if (empty($address->getPostnumber())) {
            throw new Exception("Prosze wpisac kod pocztowy!");
        }

        if (empty($address->getCity())) {
            throw new Exception("Prosze wpisac miasto!");
        }

        if (empty($address->getCountry())) {
            throw new Exception("Prosze wpisac kraj!");
        }
    }
}