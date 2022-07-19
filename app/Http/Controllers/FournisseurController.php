<?php

namespace App\Http\Controllers;

use App\Repositories\FournisseurRepository;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{

    protected $fournisseurRepository;

    public function __construct(FournisseurRepository $fournisseurRepository){
         $this->middleware(['auth']);
        $this->fournisseurRepository =$fournisseurRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs = $this->fournisseurRepository->getAll();
        return view('fournisseur.index',compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fournisseur.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fournisseurs = $this->fournisseurRepository->store($request->all());
        return redirect('fournisseur');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fournisseur = $this->fournisseurRepository->getById($id);
        return view('fournisseur.show',compact('fournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fournisseur = $this->fournisseurRepository->getById($id);
        return view('fournisseur.edit',compact('fournisseur'));
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
        $this->fournisseurRepository->update($id, $request->all());
        return redirect('fournisseur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->fournisseurRepository->destroy($id);
        return redirect('fournisseur');
    }

    public function storeJson(Request $request){
        $fournisseur = $this->fournisseurRepository->store($request->all());
        return response()->json($fournisseur);
    }
}
