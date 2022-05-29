<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $fillable = [
        'nomd'
    ];

    public function depotProduits(){
        return $this->hasMany(DepotProduit::class);
    }
    public function entrees(){
        return $this->hasMany(Entree::class);
    }
    public function sorties(){
        return $this->hasMany(Sortie::class);
    }
}
