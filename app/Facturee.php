<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturee extends Model
{

 protected $fillable =['depot_id','chauffeur_id','fournisseur_id','facs','face'];
 public function depot(){
    return $this->belongsTo(Depot::class);
}
public function fournisseur(){
    return $this->belongsTo(Fournisseur::class);
}
public function chauffeur(){
    return $this->belongsTo(Chauffeur::class);
}
public function entrees(){
    return $this->hasMany(Entree::class);
}
}
