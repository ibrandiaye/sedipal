<?php

namespace App\Repositories;

use App\Produit;

class ProduitRepository extends RessourceRepository{
    public function __construct(Produit $produit)
    {
        $this->model = $produit;
    }

    public function getProduitsWithRelation(){
        Produit::with(['entrees','sorties','sorties.client','entrees.fournisseur',
        'entrees.depot','sorties.depot'])
        ->get();
    }
}
