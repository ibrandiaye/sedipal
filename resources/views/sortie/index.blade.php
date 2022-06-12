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
                <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($sorties as $sortie)
                        <tr>
                            <td>{{ $sortie->id }}</td>
                            <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:m') }}</td>
                            <td>{{ $sortie->client->nomc }}</td>
                            <td>{{ $sortie->produit->nomp }}</td>
                            <td>{{ $sortie->quantite }}</td>
                            <td>{{ $sortie->quantite  * $sortie->prixv }}</td>
                            <td>{{ $sortie->depot->nomd }}</td>
                            @if(Auth::user()->role=='administrateur')<td>{{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}</td>@endif
                             <td>
                                <a href="{{ route('sortie.edit', $sortie->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                {!! Form::open(['method' => 'DELETE', 'route'=>['sortie.destroy', $sortie->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}



                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

