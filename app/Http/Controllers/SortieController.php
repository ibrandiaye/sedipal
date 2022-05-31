<?php

namespace App\Http\Controllers;

use App\DepotProduit;
use App\Repositories\ClientRepository;
use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SortieRepository;
use Illuminate\Http\Request;

class SortieController extends Controller
{
    protected $sortieRepository;
    protected $clientRepository;
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;

    public function __construct(SortieRepository $sortieRepository, ClientRepository $clientRepository,
    ProduitRepository $produitRepository, DepotRepository $depotRepository,
    DepotProduitRepository $depotProduitRepository){
       // $this->middleware('auth');
        $this->sortieRepository =$sortieRepository;
        $this->clientRepository = $clientRepository;
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
        $sorties = $this->sortieRepository->getAll();
        return view('sortie.index',compact('sorties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produits = $this->produitRepository->getAll();
        $clients = $this->clientRepository->getAll();
        $depots = $this->depotRepository->getAll();
        return view('sortie.add',compact('produits','clients','depots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);
        if($depotProduit->stock >= $request['quantite'])
        {
            $sorties = $this->sortieRepository->store($request->all());
            $depotProduit->stock = $depotProduit->stock - $request['quantite'] ;
            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }else{
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($request['produit_id']);
            return redirect()->back()->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
        }

        return redirect('sortie');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sortie = $this->sortieRepository->getById($id);
        return view('sortie.show',compact('sortie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sortie = $this->sortieRepository->getById($id);
        $produits = $this->produitRepository->getAll();
        $clients = $this->clientRepository->getAll();
        $depots = $this->depotRepository->getAll();
        return view('sortie.edit',compact('sortie','produits','clients','depots'));
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
        $this->sortieRepository->update($id, $request->all());
        return redirect('sortie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->sortieRepository->destroy($id);
        return redirect('sortie');
    }
}
