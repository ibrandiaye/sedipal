<?php

namespace App\Http\Controllers;

use App\DepotProduit;
use App\Repositories\DepotProduitRepository;
use App\Repositories\FactureRepository;
use App\Repositories\RetourRepository;
use App\Repositories\SortieRepository;
use App\Sortie;
use Illuminate\Http\Request;

class RetourController extends Controller
{
    protected $retourRepository;
    protected $sortieRepository;
    protected $depotProduitRepository;
    protected $factureRepository;

    public function __construct(RetourRepository $retourRepository,
    SortieRepository $sortieRepository, DepotProduitRepository $depotProduitRepository,
    FactureRepository $factureRepository){
         $this->middleware(['auth']);
        $this->retourRepository =$retourRepository;
        $this->sortieRepository = $sortieRepository;
        $this->depotProduitRepository = $depotProduitRepository;
        $this->factureRepository = $factureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retours = $this->retourRepository->getAll();
        return view('retour.index',compact('retours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('retour.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sortie = $this->sortieRepository->getById($request['sortie_id']);
        $facture = $this->factureRepository->getById($sortie->facture_id);
        if($request['quantite'] <= $sortie->quantite){
            $diff = $sortie->quantite - $request['quantite'];
            Sortie::find($sortie->id)->update(['quantite'=>$diff]);
            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($sortie->produit_id,$facture->depot_id);
            $depotProduit->stock = $depotProduit->stock  + $request['quantite'];
            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
            $retour = $this->retourRepository->store($request->all());

        }else{
            return redirect()->back()->with('error','la quantité de retour est supérieur à la quantité ');
        }
        //$sorties = $this->sortieRepository->getAll();
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retour = $this->retourRepository->getById($id);
        return view('retour.show',compact('retour'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retour = $this->retourRepository->getById($id);
        return view('retour.edit',compact('retour'));
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
        $retour = $this->retourRepository->getById($id);
        if($retour->quantite >= $request['quantite']){
            $diff = $retour->quantite - $request['quantite'];
        }else{
            $diff =  $request['quantite'] - $retour->quantite ;
        }
      /*  $sortie = $this->sortieRepository->getById($request['sortie_id']);
        if($request['quantite'] <= $sortie->quantite){
            $diff = $sortie->quantite - $request['quantite'];
            Sortie::find($sortie->id)->update(['quantite'=>$request['quantite']]);
            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($sortie->produit_id,$sortie->depot_id);
            $depotProduit->stock = $depotProduit->stock  + $diff;
            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
            $retour = $this->retourRepository->store($request->all());

        }else{
            return redirect()->back()->with('error','la quantité de retour est supérieur à la quantité ');
        }

        $this->retourRepository->update($id, $request->all());*/
        return redirect('retour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->retourRepository->destroy($id);
        return redirect('retour');
    }
}
