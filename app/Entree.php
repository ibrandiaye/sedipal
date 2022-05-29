<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    protected $fillable = [
        'produit_id', 'depot_id','quantite','prixu','fournisseur_id'
    ];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }
    public function depot(){
        return $this->belongsTo(Depot::class);
    }
    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class);
    }
}
