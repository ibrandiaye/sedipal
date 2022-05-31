<?php

namespace App\Repositories;

use App\Client;

class ClientRepository extends RessourceRepository{
    public function __construct(Client $client)
    {
        $this->model = $client;
    }
}
