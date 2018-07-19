<?php

namespace App\Repository;

use App\Repository\Contracts\UserRepository as IUserRepository;
use App\User;

class UserRepository implements IUserRepository
{
    public function getById(int $id): ?User
    {
        // TODO: Implement getById() method.
    }
}
