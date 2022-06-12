<?php

namespace App\Repositories;

use App\Depot;
use App\DepotProduit;
use Illuminate\Support\Facades\DB;

class DepotProduitRepository extends RessourceRepository{
    public function __construct(DepotProduit $depotProduit)
    {
        $this->model = $depotProduit;
    }
    public function getByProduitAndDepot($produit_id,$depot_id){
        return DB::table('depot_produits')
        ->where([['produit_id',$produit_id],['depot_id',$depot_id]])
        ->first();
    }
    public function getDepotProduitByProduit($produit_id){
        return DepotProduit::with(['produit','depot','depot.entrees','depot.sorties'])
        ->where('produit_id',$produit_id)
        ->get();
    }

}
