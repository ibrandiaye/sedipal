<?php

namespace App\Http\Controllers;

use App\DepotProduit;
use App\Entree;
use App\Repositories\ChauffeurRepository;
use App\Repositories\ClientRepository;
use App\Repositories\DepotProduitRepository;
use App\Repositories\DepotRepository;
use App\Repositories\FactureRepository;
use App\Repositories\ProduitRepository;
use App\Repositories\SortieRepository;
use App\Sortie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SortieController extends Controller
{
    protected $sortieRepository;
    protected $clientRepository;
    protected $produitRepository;
    protected $depotRepository;
    protected $depotProduitRepository;
    protected $chauffeurRepository;
    protected $factureRepository;

    public function __construct(SortieRepository $sortieRepository, ClientRepository $clientRepository,
    ProduitRepository $produitRepository, DepotRepository $depotRepository, FactureRepository $factureRepository,
    DepotProduitRepository $depotProduitRepository, ChauffeurRepository $chauffeurRepository){
         $this->middleware(['auth']);
        $this->sortieRepository =$sortieRepository;
        $this->clientRepository = $clientRepository;
        $this->produitRepository = $produitRepository;
        $this->depotRepository = $depotRepository;
        $this->depotProduitRepository = $depotProduitRepository;
        $this->chauffeurRepository = $chauffeurRepository;
        $this->factureRepository = $factureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->clientRepository->getAll();
        $sorties = $this->sortieRepository->getAll();
        $client_id = 0;
        return view('sortie.index',compact('sorties','clients','client_id'));
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
        $chauffeurs = $this->chauffeurRepository->getAll();
        $depotProduits = $this->depotProduitRepository->getByProduitAndDepotByDeport(Auth::user()->depot_id);
        return view('sortie.add',compact('produits','clients','depots','chauffeurs','depotProduits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'chauffeur_id'=> 'required|integer',
            'client_id'=> 'required|integer',
            'facs'=> 'required|string',

        ],[
            'chauffeur_id.required' => 'Chauffeur Obligatoire',
            'client_id.required' => 'Fournisseur Obligatoire',
            'facs.required' => 'N°facture Obligatoire Obligatoire',
        ]);

        $request['depot_id']=Auth::user()->depot_id;
        $arrlength = count($request['produit_id']);
        $produits = $request['produit_id'];
        $quantites = $request['quantite'];
         //control if table quantite contains value null
         for($x = 0; $x < $arrlength; $x++) {
            var_dump(is_double($quantites[$x]));
            if(is_numeric($quantites[$x])==false && is_double($quantites[$x])==false){

                return redirect()->back()->with('error','la quantité doit etre un nombre')->withInput();
            }
            if($quantites[$x]==null){
                return redirect()->back()->with('error','Vous avez oublier de renseigner une quantite')->withInput();
            }

        }
        //die();
        for($x = 0; $x < $arrlength; $x++) {
            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x],$request['depot_id']);
            if($depotProduit->stock < $quantites[$x])
            {
                $depot = $this->depotRepository->getById($request['depot_id']);
                $produit = $this->produitRepository->getById($produits[$x]);
                return redirect()->back()->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
            }
        }
       $facture =  $this->factureRepository->store($request->only(['depot_id','chauffeur_id','client_id','facs']));
        for($x = 0; $x < $arrlength; $x++) {
            $sortie = new Sortie();
            $sortie->produit_id = $produits[$x];
            $sortie->quantite = $quantites[$x];
            $sortie->prixv = 0;
            $sortie->facture_id = $facture->id;
            $sortie->save();
            $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($produits[$x],$request['depot_id']);
            $depotProduit->stock = $depotProduit->stock - $quantites[$x];

            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }
            /* $request['depot_id']=Auth::user()->depot_id;
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);

            $sorties = $this->sortieRepository->store($request->all());

            $depotProduit->stock = $depotProduit->stock - $request['quantite'] ;

            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }else{
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($request['produit_id']);
            return redirect()->back()->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
        }
*/
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
        $chauffeurs = $this->chauffeurRepository->getAll();
        return view('sortie.edit',compact('sortie','produits','clients','depots','chauffeurs'));
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
        $request['depot_id']=Auth::user()->depot_id;
        $sortie = $this->sortieRepository->getById($id);
       // dd($sortie->quantite);
        $depotProduit = $this->depotProduitRepository->getByProduitAndDepot($request['produit_id'],$request['depot_id']);
        if($depotProduit->stock + $sortie->quantite >= $request['quantite'])
        {
            $this->factureRepository->update($sortie->facture_id,$request->all());
            $this->sortieRepository->update($id, $request->all());
            $depotProduit->stock = ($depotProduit->stock + $sortie->quantite ) - $request['quantite'] ;
            DepotProduit::find($depotProduit->id)->update(['stock' =>  $depotProduit->stock]);
        }else{
            $depot = $this->depotRepository->getById($request['depot_id']);
            $produit = $this->produitRepository->getById($request['produit_id']);
            return redirect()->route('sortie.edit',['sortie'=>$id])->with('error','stock de '.$produit->nomp.'   insuffisant  dans le dépot de '.$depot->nomd);
        }
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

    public function getByDateAndClient(Request $request){
        $sorties = $this->sortieRepository->getByDateAndClient($request['date']);
        $client_id = $request['client_id'];
        $clients = $this->clientRepository->getAll();
        return view('sortie.index',compact('sorties','client_id','clients'));
    }
    public function getByFacture($facture_id){
        $sorties = $this->sortieRepository->getByFacture($facture_id);
        return view('retour.add',compact('sorties'));
    }
}
