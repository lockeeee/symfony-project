<?php


namespace App\Repository;


use App\Model\RegisteredUser;
use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RegisteredUserRepository implements UserLoaderInterface
{
    /**
     * @var Connection
     */

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(RegisteredUser $registeredUser) {
        $sql = "INSERT INTO registered(name, surname, mail, login, password) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$registeredUser->getName(), $registeredUser->getSurname(), $registeredUser->getMail(),
            $registeredUser->getLogin(), $registeredUser->getPassword()]);
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername($username){

        $sql = "SELECT * FROM registered WHERE login = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$username]);

        $registeredUserData = $stmt->fetch();
        if(empty($registeredUserData)) {

            return null;
        }

        $sql1 = "SELECT `slug` FROM `groups` JOIN `user_groups` ON groups.id = user_groups.group_id WHERE user_groups.user_id = ?";

        $stmt = $this->connection->prepare($sql1);
        $stmt->execute([$registeredUserData['id']]);

        $roles = [];
        foreach ($stmt->fetchAll() as $role){
            $roles[] = 'ROLE_' . $role['slug'];
        }



        $registeredUser = new RegisteredUser($registeredUserData['id'], $registeredUserData['name'],
            $registeredUserData['surname'], $registeredUserData['mail'], $registeredUserData['login'], $registeredUserData['password'], $roles);

        return $registeredUser;
    }
}