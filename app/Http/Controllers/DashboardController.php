<?php

namespace App\Http\Controllers;

use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\EntreeRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SortieRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;

    protected $entreeRepository;
    protected $sortieRepository;
    public function __construct(ProduitRepository $produitRepository,
    DepotRepository $depotRepository,DepotProduitRepository $depotProduitRepository,EntreeRepository $entreeRepository,
    SortieRepository $sortieRepository)
    {
        $this->middleware('auth');
        $this->produitRepository = $produitRepository;
        $this->depotRepository = $depotRepository;
        $this->depotProduitRepository = $depotProduitRepository;
        $this->entreeRepository = $entreeRepository;
        $this->sortieRepository = $sortieRepository;
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
        $stocks = $this->depotRepository->getStockByDepots();
        //dd($stocks);
        return view('welcome',compact('depots','stocks'));
    }
    public function getProduitDepotById($produit_id){
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($produit_id);
        $produit = $this->produitRepository->getById($produit_id);
        $entrees = $this->entreeRepository->getByProduitId($produit_id);
        $sorties = $this->sortieRepository->getByProduitId($produit_id);
        return view('show',compact('depotProduits','produit','sorties','entrees'));
    }
    public function getProduitDepotByIdBetweenToDate(Request $request){
        //dd($request['produit_id']);
        $depotProduits = $this->depotProduitRepository->getDepotProduitByProduit($request['produit_id']);
        $produit = $this->produitRepository->getById($request['produit_id']);
        $entrees = $this->entreeRepository->getByProduitIdBetweenToDate($request['produit_id'],$request['from'],$request['to']);
        $sorties = $this->sortieRepository->getByProduitIdBetweenToDate($request['produit_id'],$request['from'],$request['to']);
        return view('show',compact('depotProduits','produit','sorties','entrees'));
    }
    public function  getByDepot($id){
        $depot = $this->depotRepository->getByDepot($id);
        return view('depot.show',compact('depot'));
    }
}
