<?php

namespace App\Repository;

use App\Model\User;
use App\Service\Search\SearchUserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class SearchUserRepository implements SearchUserInterface
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
    public function findUser($search): array
    {
        $sql = "SELECT id, name, surname, mail, pnumber from users WHERE name LIKE CONCAT(?, '%')";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$search]);
        $records = [];

        foreach ($stmt->fetchAll() as $userData) {
            $records[] = new User(
                $userData['id'],
                $userData['name'],
                $userData['surname'],
                $userData['mail'],
                $userData['pnumber']
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
    public function advancedFindUser(array $criteria): array
    {
        $sql = "SELECT id, name, surname, mail, pnumber from users ";

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

        foreach ($stmt->fetchAll() as $userData) {
            $records[] = new User(
                $userData['id'],
                $userData['name'],
                $userData['surname'],
                $userData['mail'],
                $userData['pnumber']
            );
        }

        return $records;
    }
}