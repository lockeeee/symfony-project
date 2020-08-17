<?php

namespace App\Repository;

use App\Model\Address;
use App\Model\User;
use App\Service\Search\SearchAddressInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class SearchAddressRepository implements SearchAddressInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $search
     *
     * @return array
     * @throws DBALException
     */
    public function findAddress($search): array
    {
        $sql = "SELECT 
                    address.id,
                    user_id,
                    street,
                    postnumber,
                    city,
                    country,
                    user_id,
                    name,
                    surname,
                    mail,
                    pnumber 
                FROM 
                    address
                INNER JOIN 
                    users u on address.user_id = u.ID 
                WHERE street LIKE CONCAT(?, '%')";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$search]);
        $records = [];

        foreach ($stmt->fetchAll() as $addressData) {
            $user = new User(
                $addressData['user_id'],
                $addressData['name'],
                $addressData['surname'],
                $addressData['mail'],
                $addressData['pnumber']
            );
            $records[] = new Address(
                $addressData['id'],
                $addressData['user_id'],
                $addressData['street'],
                $addressData['postnumber'],
                $addressData['city'],
                $addressData['country'],
                $user
            );
        }

        return $records;
    }

    /**
     * @param array $criteria
     *
     * @return array
     * @throws DBALException
     */
    public function advancedFindAddress(array $criteria): array
    {
        $sql = "SELECT 
                    address.id,
                    user_id,
                    street,
                    postnumber,
                    city,
                    country,
                    user_id,
                    name,
                    surname,
                    mail,
                    pnumber 
                FROM 
                    address
                INNER JOIN 
                    users u on address.user_id = u.ID ";

        $parameters = [];
        $conditions = [];

        foreach ($criteria as $key => $value) {
            if (!empty($value)) {
                $conditions[] = " $key LIKE CONCAT(?, '%')";
                $parameters[] = $value;
            }
        }

        if (!empty($conditions)) {
            $sql .= "WHERE " . implode(' OR ', $conditions);
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($parameters);
        $records = [];

        foreach ($stmt->fetchAll() as $addressData) {
            $user = new User(
                $addressData['user_id'],
                $addressData['name'],
                $addressData['surname'],
                $addressData['mail'],
                $addressData['pnumber']
            );
            $records[] = new Address(
                $addressData['id'],
                $addressData['user_id'],
                $addressData['street'],
                $addressData['postnumber'],
                $addressData['city'],
                $addressData['country'],
                $user
            );
        }

        return $records;
    }
}