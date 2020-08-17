<?php

namespace App\Repository;

use App\Model\Address;
use App\Model\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class AddressRepository
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
     * @return array
     * @throws DBALException
     */
    public function findAddresses(): array
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
                    users u on address.user_id = u.ID";

        $stmt = $this->connection->query($sql);
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
     * @param $sort
     * @param string $direction
     *
     * @return array
     * @throws DBALException
     */
    public function findSortedAddresses($sort, $direction = 'asc'): array
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
                    users u on address.user_id = u.ID";

        if (in_array($sort, ['id', 'name', 'street', 'postnumber', 'city', 'country']) && in_array($direction, ['asc', 'desc'])) {
            $sql .= " ORDER BY $sort $direction";
        }

        $stmt = $this->connection->query($sql);
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
     * @param Address $address
     *
     * @return bool
     * @throws DBALException
     */
    public function create(Address $address): bool
    {
        $sql = "INSERT INTO address(user_id, street, postnumber, city, country) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(
            [
                $address->getUserId(),
                $address->getStreet(),
                $address->getPostnumber(),
                $address->getCity(),
                $address->getCountry()
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws DBALException
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM address WHERE id = ?";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$id]);
    }

    /**
     * @param $id
     *
     * @return Address|null
     * @throws DBALException
     */
    public function find($id)
    {
        $sql = "SELECT * FROM address WHERE id = ?";
        $stmt = $this->connection->prepare($sql);

        if (!$stmt->execute([$id])) {
            return NULL;
        }

        $addressData = $stmt->fetch();

        if (empty($addressData)) {
            return NULL;
        }

        $user = new Address(
            $addressData['id'],
            $addressData['user_id'],
            $addressData['street'],
            $addressData['postnumber'],
            $addressData['city'],
            $addressData['country'],
            NULL
        );

        return $user;
    }

    /**
     * @param Address $address
     *
     * @return bool
     * @throws DBALException
     */
    public function update(Address $address): bool
    {
        $sql = "UPDATE address SET user_id = ?, street = ?, postnumber = ?, city = ?, country = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(
            [
                $address->getUserId(),
                $address->getStreet(),
                $address->getPostnumber(),
                $address->getCity(),
                $address->getCountry(),
                $address->getId()
            ]
        );
    }
}