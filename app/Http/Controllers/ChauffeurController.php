<?php

namespace App\Http\Controllers;

use App\Repositories\ChauffeurRepository;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{

    protected $chauffeurRepository;

    public function __construct(ChauffeurRepository $chauffeurRepository){
        $this->middleware('auth');
        $this->chauffeurRepository =$chauffeurRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chauffeurs = $this->chauffeurRepository->getAll();
        return view('chauffeur.index',compact('chauffeurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chauffeur.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chauffeurs = $this->chauffeurRepository->store($request->all());
        return redirect('chauffeur');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chauffeur = $this->chauffeurRepository->getById($id);
        return view('chauffeur.show',compact('chauffeur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chauffeur = $this->chauffeurRepository->getById($id);
        return view('chauffeur.edit',compact('chauffeur'));
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
        $this->chauffeurRepository->update($id, $request->all());
        return redirect('chauffeur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->chauffeurRepository->destroy($id);
        return redirect('chauffeur');
    }
    public function storeJson(Request $request)
    {
        $chauffeur = $this->chauffeurRepository->store($request->all());
        return response()->json($chauffeur);

    }
}
