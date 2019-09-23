<?php


namespace App\Security;


use App\Model\RegisteredUser;
use App\Repository\RegisteredUserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{

    /**
     * @var RegisteredUserRepository
     */
    private $registeredUserRepository;

    public function __construct(RegisteredUserRepository $registeredUserRepository)
    {
        $this->registeredUserRepository = $registeredUserRepository;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $registeredUser = $this->registeredUserRepository->loadUserByUsername($username);

        if(empty($registeredUser)) {
            throw new UsernameNotFoundException();
        }
        return $registeredUser;
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException  if the user is not supported
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user)
    {
        $username = $user->getUsername();
        $registeredUser = $this->registeredUserRepository->loadUserByUsername($username);

        if(empty($registeredUser)) {
            throw new UsernameNotFoundException();
        }

        return $registeredUser;
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return RegisteredUser::class === $class;
    }
}