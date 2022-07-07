@extends('layout')
@section('title', '| produit')
@section('css')
<link rel="stylesheet" href="{!! asset('assets/plugins/daterangepicker/daterangepicker.css') !!}">
@endsection
@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">{{ $depot->nomd }} </h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
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
    <section class="content">
        <div class="container-fluid">
    {{--
<div class="row">
 <div class="col-sm-12">
    <form action="{{ route('detail.produit.between.to.date') }}" method="POST">
        @csrf
        <div class="form-group">
    <div class="col-sm-6">


    <input type="hidden" id="from" name="from"  value="{{ old('from') }}"  required>
    <input type="hidden" id="to" name="to"  value="{{ old('to') }}"  required>


        <div class="input-group">
          <div class="input-group-prepend">
            <label> Periode:</label>
            <span class="input-group-text">
              <i class="far fa-calendar-alt"></i>
            </span>
          </div>
          <input type="text" name="daterange" class="form-control float-right" id="reservation">
          <button type="submit" class="btn btn-success btn  "> Rechercher</button>
        </div>
        <!-- /.input group -->
      </div>


      <input id="depot_id" type="hidden" value="{{ $produit->id }}" name="produit_id">
    </div>
    </form>
</div>
    </div>  --}}
<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center"><h5>Liste des entrées </h5></div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                            <th>Montant</th>
                            <th>Depot</th>
                            <th>Chauffeur</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($depot->entrees as $entree)
                        <tr>
                            <td>{{  Carbon\Carbon::parse($entree->created_at)->format('d-m-Y H:m') }}</td>
                            <td>{{ $entree->produit->nomp }}</td>
                            <td>{{ $entree->quantite }}</td>
                            <td>{{ $entree->prixu * $entree->quantite }}</td>
                            <td>{{ $entree->depot->nomd }}</td>
                            <td>@if($entree->chauffeur) {{ $entree->chauffeur->nom }}@endif</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="card border-danger border-0">
            <div class="card-header bg-success text-center"><h5>Liste des Sorties </h5></div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Produit</th>
                                <th>Quantite</th>
                                <th>Montant</th>
                                <th>Dépot</th>
                                <th>Chauffeur</th>
                                @if(Auth::user()->role=='administrateur')<th>Ecart</th>@endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($depot->sorties as $sortie)
                            <tr>
                                <td>{{  Carbon\Carbon::parse( $sortie->created_at)->format('d-m-Y H:m') }}</td>
                                <td>{{ $sortie->produit->nomp }}</td>
                                <td>{{ $sortie->quantite }}</td>
                                <td>{{ $sortie->prixv * $sortie->quantite }}</td>
                                <td>{{ $sortie->depot->nomd }}</td>
                                <td> @if($sortie->chauffeur)
                                    {{ $sortie->chauffeur->nom }}
                                @endif</td>
                                @if(Auth::user()->role=='administrateur')<td>{{( $sortie->quantite  * $sortie->prixv) - ($sortie->quantite  * $sortie->produit->prixu) }}</td>@endif
                            </tr>
                            @endforeach

                        </tbody>
                    </table>



                </div>

            </div>
        </div>
        </div>
    </section>
</div>

@endsection
