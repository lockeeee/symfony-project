<?php


namespace App\Repository;


use App\Model\User;
use Doctrine\DBAL\Connection;

class UserRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function findAll() {
        $sql = "SELECT id, name, surname, mail, pnumber from users";
        $stmt = $this->connection->query($sql);
        $records = [];

        foreach ($stmt->fetchAll() as $userData) {
            $records[] = new \App\Model\User($userData['id'], $userData['name'], $userData['surname'], $userData['mail'],
                $userData['pnumber']);
        }

        return $records;
    }

    public function find($id) {
        $sql = "SELECT * from users WHERE id = ?";

        $stmt = $this->connection->prepare($sql);
        if(!$stmt->execute([$id])) {
            return NULL;
        }

        $userData= $stmt->fetch();

        if (empty($userData)) {
            return NULL;
        }
        $user = new User($userData['id'], $userData['name'], $userData['surname'], $userData['mail'], $userData['pnumber']);
        return $user;
    }

    public function update(User $user) {
        $sql = "UPDATE users SET name = ?, surname = ?, mail = ?, pnumber = ? WHERE ID = ?";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$user->getName(), $user->getSurname(), $user->getMail(), $user->getPnumber(), $user->getId()]);
    }

    public function create(User $user) {
        $sql = "INSERT INTO users(name, surname, mail, pnumber) VALUES (?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$user->getName(), $user->getSurname(), $user->getMail(), $user->getPnumber()]);
    }

    public function delete($id) {
        $sql = "DELETE from users WHERE id = ?";

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$id]);
    }
}