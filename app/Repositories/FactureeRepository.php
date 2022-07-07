<?php

namespace App\Repositories;

use App\Facturee;

class FactureeRepository extends RessourceRepository{
    public function __construct(Facturee $facturee)
    {
        $this->model = $facturee;
    }
}
