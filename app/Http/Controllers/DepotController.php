<?php

namespace App\Http\Controllers;

use App\DepotProduit;
use App\Repositories\DepotRepository;
use App\Repositories\ProduitRepository;
use Illuminate\Http\Request;

class DepotController extends Controller
{
    protected $depotRepository;
    protected $produitRepository;

    public function __construct(DepotRepository $depotRepository,
    ProduitRepository $produitRepository){
        // $this->middleware(['auth']);
        $this->depotRepository =$depotRepository;
        $this->produitRepository = $produitRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depots = $this->depotRepository->getAll();
        return view('depot.index',compact('depots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('depot.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produits = $this->produitRepository->getAll();
        $depot = $this->depotRepository->store($request->all());
        foreach ($produits as $produit) {
            $depotProduit = new DepotProduit();
            $depotProduit->produit_id= $produit->id;
            $depotProduit->depot_id = $depot->id;
            $depotProduit->stock = 0;
            $depotProduit->save();
        }
        return redirect('depot');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $depot = $this->depotRepository->getById($id);
        return view('depot.show',compact('depot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depot = $this->depotRepository->getById($id);
        return view('depot.edit',compact('depot'));
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
        $this->depotRepository->update($id, $request->all());
        return redirect('depot');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->depotRepository->destroy($id);
        return redirect('depot');
    }
}
