<?php

namespace App\Repositories;

use App\DepotProduit;

class DepotProduitRepository extends RessourceRepository{
    public function __construct(DepotProduit $depotProduit)
    {
        $this->model = $depotProduit;
    }
}
