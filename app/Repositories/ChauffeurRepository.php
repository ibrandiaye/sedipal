<?php

namespace App\Repositories;

use App\Chauffeur;

class ChauffeurRepository extends RessourceRepository{
    public function __construct(Chauffeur $Chauffeur)
    {
        $this->model = $Chauffeur;
    }
}
