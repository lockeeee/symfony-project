<?php


namespace App\Repository;


use App\Service\Search\SearchUserInterface;
use Doctrine\DBAL\Connection;

class SearchUserRepository implements SearchUserInterface
{

    /**
     * @var Connection
     */
    private $connection;

    public function findUser($search)
    {
        $sql = "SELECT id, name, surname, mail, pnumber from users WHERE name LIKE CONCAT(?, '%')";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$search]);
        $records = [];

        foreach ($stmt->fetchAll() as $userData) {
            $records[] = new \App\Model\User($userData['id'], $userData['name'], $userData['surname'], $userData['mail'],
                $userData['pnumber']);
        }

        return $records;
    }

    public function advancedFindUser(array $criteria) {

        $sql = "SELECT id, name, surname, mail, pnumber from users ";
//        $sql = "SELECT id, name, surname, mail, pnumber from users WHERE name LIKE CONCAT(?, '%') OR surname LIKE CONCAT(?, '%')";

        $parameters = [];
        $conditions = [];

        if(!empty($criteria['name'])) {
            $conditions[] = "name LIKE CONCAT(?, '%')";
            $parameters[] = $criteria['name'];
        }

        if(!empty($criteria['surname'])) {
            $conditions[] = "surname LIKE CONCAT(?, '%')";
            $parameters[] = $criteria['surname'];
        }

        if(!empty($conditions)) {
            $sql .= "WHERE " . implode(' OR ', $conditions);
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($parameters);

        $records = [];

        foreach ($stmt->fetchAll() as $userData) {
            $records[] = new \App\Model\User($userData['id'], $userData['name'], $userData['surname'], $userData['mail'],
                $userData['pnumber']);
        }

        return $records;
    }

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


}