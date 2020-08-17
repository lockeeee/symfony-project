<?php

namespace App\Security;

use App\Model\RegisteredUser;
use App\Repository\RegisteredUserRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var RegisteredUserRepository
     */
    private $registeredUserRepository;

    /**
     * @param RegisteredUserRepository $registeredUserRepository
     */
    public function __construct(RegisteredUserRepository $registeredUserRepository)
    {
        $this->registeredUserRepository = $registeredUserRepository;
    }

    /**
     * @param string $username
     *
     * @return UserInterface
     * @throws UsernameNotFoundException
     * @throws DBALException
     */
    public function loadUserByUsername($username): UserInterface
    {
        $registeredUser = $this->registeredUserRepository->loadUserByUsername($username);

        if (empty($registeredUser)) {
            throw new UsernameNotFoundException();
        }

        return $registeredUser;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     * @throws DBALException
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        $username = $user->getUsername();
        $registeredUser = $this->registeredUserRepository->loadUserByUsername($username);

        if (empty($registeredUser)) {
            throw new UsernameNotFoundException();
        }

        return $registeredUser;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return RegisteredUser::class === $class;
    }
}