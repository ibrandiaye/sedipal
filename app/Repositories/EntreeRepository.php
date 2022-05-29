<?php

namespace App\Repositories;

use App\Entree;

class EntreeRepository extends RessourceRepository{
    public function __construct(Entree $entree)
    {
        $this->model = $entree;
    }
}
