<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
 protected $fillable =['depot_id','chauffeur_id','client_id','facs'];

 public function depot(){
    return $this->belongsTo(Depot::class);
}
public function client(){
    return $this->belongsTo(Client::class);
}
public function chauffeur(){
    return $this->belongsTo(Chauffeur::class);
}
public function sorties(){
    return $this->hasMany(Sortie::class);
}
}

