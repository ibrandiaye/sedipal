<?php

namespace App\Repositories;

use App\User;

class UserRepository extends RessourceRepository{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

}
