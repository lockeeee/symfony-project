<?php

namespace App\Repository;

use App\Model\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class UserRepository
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
    public function findAll(): array
    {
        $sql = "SELECT id, name, surname, mail, pnumber from users";
        $stmt = $this->connection->query($sql);
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
     * @param $sort
     * @param string $direction
     *
     * @return array
     * @throws DBALException
     */
    public function findAllSorted($sort, string $direction = 'asc'): array
    {
        $sql = "SELECT id, name, surname, mail, pnumber from users";

        if (in_array($sort, ['id', 'name', 'surname', 'mail', 'pnumber']) && in_array($direction, ['asc', 'desc'])) {
            $sql .= " ORDER BY $sort $direction";
        }

        $stmt = $this->connection->query($sql);
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
     * @param int $id
     *
     * @return User|null
     * @throws DBALException
     */
    public function find(int $id)
    {
        $sql = "SELECT * from users WHERE id = ?";
        $stmt = $this->connection->prepare($sql);

        if (!$stmt->execute([$id])) {
            return NULL;
        }

        $userData= $stmt->fetch();

        if (empty($userData)) {
            return NULL;
        }

        $user = new User(
            $userData['id'],
            $userData['name'],
            $userData['surname'],
            $userData['mail'],
            $userData['pnumber']
        );

        return $user;
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws DBALException
     */
    public function update(User $user): bool
    {
        $sql = "UPDATE users SET name = ?, surname = ?, mail = ?, pnumber = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(
            [
                $user->getName(),
                $user->getSurname(),
                $user->getMail(),
                $user->getPnumber(),
                $user->getId()
            ]
        );
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws DBALException
     */
    public function create(User $user): bool
    {
        $sql = "INSERT INTO users(name, surname, mail, pnumber) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(
            [
                $user->getName(),
                $user->getSurname(),
                $user->getMail(),
                $user->getPnumber()
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
        $sql = "DELETE from users WHERE id = ?";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$id]);
    }
}