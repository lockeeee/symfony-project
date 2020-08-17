<?php

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;
use App\Validator\UserValidator;
use Doctrine\DBAL\DBALException;

class UserService
{
    /**
     * @var UserValidator
     */
    private $userValidator;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserValidator  $userValidator
     * @param UserRepository $userRepository
     */
    public function __construct(UserValidator $userValidator, UserRepository $userRepository)
    {
        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     *
     * @throws DBALException
     */
    public function createUser(User $user)
    {
        $this->userValidator->validate($user);
        $this->userRepository->create($user);
    }

    /**
     * @param $sort
     * @param $sortOrder
     *
     * @return array
     * @throws DBALException
     */
    public function showUsers($sort, $sortOrder): array
    {
        return $this->userRepository->findAllSorted($sort, $sortOrder);
    }

    /**
     * @return array
     * @throws DBALException
     */
    public function showUsersForAssign(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param int $id
     *
     * @return User|null
     * @throws DBALException
     */
    public function userData(int $id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws DBALException
     */
    public function deleteUser(int $id)
    {
        return $this->userRepository->delete($id);
    }

    /**
     * @param User $user
     *
     * @throws DBALException
     */
    public function updateUser(User $user)
    {
        $this->userValidator->validate($user);
        $this->userRepository->update($user);
    }


}