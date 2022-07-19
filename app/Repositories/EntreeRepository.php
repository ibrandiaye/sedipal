<?php

namespace App\Repositories;

use App\Entree;

class EntreeRepository extends RessourceRepository{
    public function __construct(Entree $entree)
    {
        $this->model = $entree;
    }

    public function getByProduitId($produit_id){
        return Entree::with(['produit','facturee','facturee.depot','facturee.fournisseur'])
        ->where('produit_id',$produit_id)
        ->orderBy('id','desc')
        ->get();
    }
    public function getByProduitIdBetweenToDate($produit_id,$debut,$fin){
        return Entree::with(['produit','facturee','facturee.depot','facturee.fournisseur'])
        ->where('produit_id',$produit_id)
        ->whereBetween('created_at',[$debut,$fin])
        ->orderBy('id','desc')
        ->get();
    }
}
