<?php

namespace App\Repositories;

use App\Depot;

class DepotRepository extends RessourceRepository{
    public function __construct(Depot $depot)
    {
        $this->model = $depot;
    }
}
