<?php

namespace App\Repositories;

use App\Produit;

class ProduitRepository extends RessourceRepository{
    public function __construct(Produit $produit)
    {
        $this->model = $produit;
    }
}
