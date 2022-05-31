<?php

namespace App\Http\Controllers;

use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;
    public function __construct(ProduitRepository $produitRepository,
    DepotRepository $depotRepository,DepotProduitRepository $depotProduitRepository)
    {
        $this->produitRepository = $produitRepository;
        $this->depotRepository = $depotRepository;
        $this->depotProduitRepository = $depotProduitRepository;
    }

    public function  listProduit(){
        $produits = $this->produitRepository->getAll();
        foreach ($produits as $key => $produit) {
            $totalEntre = 0;
            $totalSortie = 0;
            foreach ($produit->entrees as $key1 => $entree) {
                if($produit->id == $entree->produit_id){
                    $totalEntre = $totalEntre + $entree->quantite;
                }
            }
            foreach ($produit->sorties as $key2 => $sortie) {
                if($produit->id == $sortie->produit_id){
                    $totalSortie = $totalSortie + $sortie->quantite;
                }
            }
            $produits[$key]->stocke = $totalEntre;
            $produits[$key]->stocks = $totalSortie;
        }
      // dd($produits);
      return view('welcome');
    }
    public function home(){
        $depots = $this->depotRepository->getDepotWithRelation();
        return view('welcome',compact('depots'));
    }
    public function getProduitDepotById($produit_id){
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($produit_id);
        $produit = $this->produitRepository->getById($produit_id);
        return view('show',compact('depotProduits','produit'));
    }
}
