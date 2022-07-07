<?php

namespace App\Repositories;

use App\Transfert;

class TransfertRepository extends RessourceRepository{
    public function __construct(Transfert $transfert)
    {
        $this->model = $transfert;
    }
}
