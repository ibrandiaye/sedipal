<?php

namespace App\Repositories;

use App\Facture;

class FactureRepository extends RessourceRepository{
    public function __construct(Facture $facture)
    {
        $this->model = $facture;
    }

    public function getFactureByDepot($depot_id){
        return Facture::with(['client','depot','chauffeur'])
        ->where('depot_id',$depot_id)
        ->orderBy('id','desc')
        ->get();
    }
}
