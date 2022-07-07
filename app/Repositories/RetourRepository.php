<?php

namespace App\Repositories;

use App\Retour;

class RetourRepository extends RessourceRepository{
    public function __construct(Retour $retour)
    {
        $this->model = $retour;
    }


}
