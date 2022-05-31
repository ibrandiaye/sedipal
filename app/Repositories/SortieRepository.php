<?php

namespace App\Repositories;

use App\Sortie;

class SortieRepository extends RessourceRepository{
    public function __construct(Sortie $sortie)
    {
        $this->model = $sortie;
    }
}
