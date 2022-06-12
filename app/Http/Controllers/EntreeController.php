<?php

namespace App\Http\Controllers;

use App\DepotProduit;
use App\Produit;
use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\EntreeRepository;
use App\Repositories\FournisseurRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;

class EntreeController extends Controller
{

    protected $entreeRepository;
    protected $fournisseurRepository;
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;

    public function __construct(EntreeRepository $entreeRepository, FournisseurRepository $fournisseurRepository,
    ProduitRepository $produitRepository, DepotRepository $depotRepository,
    DepotProduitRepository $depotProduitRepository){
        // $this->middleware(['auth']);
        $this->entreeRepository =$entreeRepository;
        $this->fournisseurRepository = $fournisseurRepository;
        $this->produitRepository = $produitRepository;
        $this->depotRepository = $depotRepository;
        $this->depotProduitRepository = $depotProduitRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entrees = $this->entreeRepository->getAll();
        return view('entree.index',compact('entrees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produits = $this->produitRepository->getAll();
        $fournisseurs = $this->fournisseurRepository->getAll();
        $depots = $this->depotRepository->getAll();
        return view('entree.add',compact('produits','fournisseurs','depots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entree = $this->entreeRepository->store($request->all());
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);
        $depotProduit->stock = $request['quantite'] + $depotProduit->stock;
        DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        Produit::find($depotProduit->produit_id)->update(['prixu'=>$entree->prixu]);
        return redirect('entree');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entree = $this->entreeRepository->getById($id);
        return view('entree.show',compact('entree'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entree = $this->entreeRepository->getById($id);
        $produits = $this->produitRepository->getAll();
        $fournisseurs = $this->fournisseurRepository->getAll();
        $depots = $this->depotRepository->getAll();
        return view('entree.edit',compact('entree','produits','fournisseurs','depots'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->entreeRepository->update($id, $request->all());
        return redirect('entree');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->entreeRepository->destroy($id);
        return redirect('entree');
    }
}
