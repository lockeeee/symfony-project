<?php


namespace App\Service;


use App\Model\User;
use App\Repository\UserRepository;
use App\Validator\UserValidator;

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

    public function __construct(UserValidator $userValidator, UserRepository $userRepository)
    {

        $this->userValidator = $userValidator;
        $this->userRepository = $userRepository;
    }

    public function createUser(User $user) {

        $this->userValidator->validate($user);
        $this->userRepository->create($user);
    }

    public function showUsers($sort, $sortOrder) {

        return $this->userRepository->findAllSorted($sort, $sortOrder);
    }

    public function showUsersForAssign() {

        return $this->userRepository->findAll();
    }

    public function userData($id) {

        return $this->userRepository->find($id);
    }

    public function deleteUser($id) {

        return $this->userRepository->delete($id);
    }

    public function updateUser(User $user) {

        $this->userValidator->validate($user);
        $this->userRepository->update($user);
    }


}