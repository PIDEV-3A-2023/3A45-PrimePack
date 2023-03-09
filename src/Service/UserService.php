<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Finds all countries
     */
    public function findAll() {

        $data = $this->userRepository->getUsers(0,1);

        return $data;
    }

}