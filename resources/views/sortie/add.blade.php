@extends('layout')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="container">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-info">GESTION DES SORTIES</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('produit.index') }}" role="button" class="btn btn-success">LISTE D'ENREGISTREMENT DES SORTIES</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        <form action="{{ route('sortie.store') }}" method="POST">
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE D'ENREGISTREMENT D'UNE SORTIE</div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Depots</label>
                                        <select class="form-control select2" id="depot_id" name="depot_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($depots as $depot)
                                            <option value="{{$depot->id}}">{{$depot->nomd}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Produit</label>
                                        <select class="form-control select2" id="produit_id" name="produit_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($produits as $produit)
                                            <option value="{{$produit->id}}">{{$produit->nomp}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control select2" id="client_id" name="client_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->nomc}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix Unitaire produit</label>
                                        <input type="number" id="prixv" name="prixv"  value="{{ old('prixv') }}" step='0.01' class="calcul form-control"  >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Quantité</label>
                                        <input type="number" name="quantite" id="quantite"  value="{{ old('quantite') }}" step='0.01' class="calcul  form-control"  required>
                                    </div>
                                </div>
                                <div>
                                    <center>
                                        <button type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>
                                    </center>
                                </div>
                            </div>

                            </div>

            </form>
            </div>
        </div>



@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
$(document).ready(function(){
    //alert('keuup');
    $(".calcul").keyup(function(){
        console.log('keuup');
       var prixu = $("#prixv").val();
       var quantite = $("#quantite").val();
       console.log(prixu * quantite);
      });
});
</script>
@endsection



