<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    protected $fillable = [
        'produit_id', 'depot_id','quantite','prixv','client_id'
    ];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }
    public function depot(){
        return $this->belongsTo(Depot::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
}
