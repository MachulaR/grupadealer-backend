<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\UserNotExistException;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->em = $entityManager;
    }

    public function getUsersByLogins(array $logins)
    {
        $users = [];
        foreach ($logins as $login) {
            $user = $this->em
                ->getRepository(User::class)
                ->findOneBy(['login' => $login]);

            if (!$user) {
            throw new UserNotExistException();
            }
            $users[] = $user;

        }
        return $users;
    }
}
