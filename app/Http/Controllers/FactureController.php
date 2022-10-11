<?php

namespace App\Http\Controllers;

use App\Repositories\FactureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    protected $factureRepository;
    public function __construct(FactureRepository $factureRepository)
    {
        $this->middleware(['auth']);
        $this->factureRepository = $factureRepository;
    }

    public function fac(){
        //dd('kh');
        if(Auth::user()->role=="gestionnaire"){
            $factures = $this->factureRepository->getFactureByDepot(Auth::user()->depot_id);
        }else{
            $factures = $this->factureRepository->getAll();
        }
        return view('facture.index',compact('factures'));
    }

    public function getById($facture_id){
        $facture = $this->factureRepository->getById($facture_id);
        return view('facture.show',compact('facture'));
    }
    public function impression($facture_id){
        $facture = $this->factureRepository->getById($facture_id);
        return view('facture.impression',compact('facture'));
    }
}
