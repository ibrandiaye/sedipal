<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nomp', 'prixu','unite'
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
    public function transferts(){
        return $this->hasMany(Transfert::class);
    }
}
