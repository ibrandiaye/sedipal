@extends('layout')
@section('title', '| sortie')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">GESTION DES SORTIES</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('sortie.create') }}" role="button" class="btn btn-success">ENREGISTRER UNE SORTIE</a></li>
                                </ol>
                            </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
            </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center">LISTE D'ENREGISTREMENT DES SORTIES</div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>client</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            <th>Montant</th>
                            <th>Depot</th>
                            @if(Auth::user()->role=='administrateur')<th>Ecart</th>@endif
                            <th>chauffeur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($sorties as $sortie)
                        <tr>
                            <td>{{ $sortie->id }}</td>
                            <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{ $sortie->facture->client->nomc }}</td>
                            <td>{{ $sortie->produit->nomp }}</td>
                            <td>{{ $sortie->quantite }}</td>
                            <td>{{ $sortie->quantite  * $sortie->prixv }}</td>
                            <td>{{ $sortie->facture->depot->nomd }}</td>
                            @if(Auth::user()->role=='administrateur')<td>{{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}</td>@endif
                            <td> @if($sortie->facture->chauffeur)
                                {{ $sortie->facture->chauffeur->nom }}
                            @endif</td>
                             <td>
                                @if(Auth::user()->depot_id== $sortie->facture->depot->id)
                                <a href="{{ route('sortie.edit', $sortie->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default{{ $sortie->id }}">
                                    Retour
                                  </button>
                                @endif
                                @if(Auth::user()->role== 'administrateur') {!! Form::open(['method' => 'DELETE', 'route'=>['sortie.destroy', $sortie->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}@endif



                            </td>

                        </tr>

                        <div class='modal fade' id='modal-default{{ $sortie->id }}'>
                            <form action="{{ route('retour.store') }}" method="POST">
                            @csrf

                            <div class='modal-dialog'>
                              <div class='modal-content'>
                                <div class='modal-header'>
                                  <h6 class='modal-title'> Retour : {{ $sortie->produit->nomp }},  Facture N°{{ $sortie->facs }}</h6>
                                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>
                                <div class='modal-body'>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Quantité</label>
                                                <input type="number" name="quantite" id="quantite"  value="{{ old('quantite') }}" step='0.01' max="{{ $sortie->quantite }}" class="calcul  form-control"  required>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ $sortie->id }}" name="sortie_id">

                                </div>
                                <div class='modal-footer justify-content-between'>
                                  <button type='button' class='btn btn-default' data-dismiss='modal'>Fermer</button>
                                  <input type='submit' class='btn btn-success' value="Valider Retour">
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </form>
                        </div>

                          <!-- /.modal -->
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

