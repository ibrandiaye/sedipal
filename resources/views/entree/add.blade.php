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
                        <h1 class="m-0 text-info">GESTION DES ENTREES</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('produit.index') }}" role="button" class="btn btn-success">LISTE D'ENREGISTREMENT DES ENTREES</a></li>

                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        <form action="{{ route('entree.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
             <div class="card border-danger border-0">
                        <div class="card-header bg-success text-center">FORMULAIRE D'ENREGISTREMENT D'UNE ENTREE</div>
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
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Depots</label>
                                        <select class="form-control" id="depot_id" name="depot_id" required="" {{ Auth::user()->role=="gestionnaire" ? "disabled='true'" : ''  }} >
                                            <option value="">Selectionnez</option>
                                            @foreach ($depots as $depot)
                                            <option value="{{$depot->id}}" {{  Auth::user()->depot_id==$depot->id ? 'selected' : '' }}>{{$depot->nomd}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>
                                {{--  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Produit</label>
                                        <select class="form-control select2" id="produit_id" name="produit_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($produits as $produit)
                                            <option value="{{$produit->id}}">{{$produit->nomp}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                </div>  --}}
                                <div class="col-lg-6">

                                        <label>Fournisseur</label>
                                        <div class="form-group  input-group input-group-sm">
                                        <select class="form-control select2" id="fournisseur_id" name="fournisseur_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($fournisseurs as $fournisseur)
                                            <option value="{{$fournisseur->id}}">{{$fournisseur->nomf}}</option>
                                                @endforeach

                                        </select>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-default1">Nouveau Fournisseur!</button>
                                          </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>N° Facture</label>
                                        <input type="text" name="facs" id="facs"  value="{{ old('facs') }}" class="form-control"  required>
                                    </div>
                                </div>
                               {{--   <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Prix Unitaire produit</label>
                                        <input type="number" id="prixu" name="prixu"  value="{{ old('prixu') }}" step='0.01' class="calcul form-control"  >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Quantité</label>
                                        <input type="number" name="quantite" id="quantite"  value="{{ old('quantite') }}" step='0.01' class="calcul  form-control"  required>
                                    </div>
                                </div>  --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Facture</label>
                                        <input type="file" name="facture" id="facture"   class=" form-control"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Chauffeur</label>
                                    <div class=" form-group input-group input-group-sm">

                                        <select class="form-control select2" id="chauffeur_id" name="chauffeur_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($chauffeurs as $chauffeur)
                                            <option value="{{$chauffeur->id}}">{{$chauffeur->nom }}</option>
                                                @endforeach

                                        </select>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-default">Nouveau Chauffeur!</button>
                                          </span>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table table2 table-bordered" id="ta">
                                            <thead>

                                            <tr>
                                                <th>#</th>
                                                <th>Plat</th>
                                                <th>stock</th>
                                                <th>Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($produits as $produit)
                                                <tr>
                                                    <td class="id">{{ $produit->id }}</td>
                                                    <td class="name"> {{ $produit->nomp }}</td>
                                                    <td class=""> @foreach ($depotProduits as $depotProduit )
                                                        @if($produit->id== $depotProduit->produit_id)
                                                        {{ $depotProduit->stock }}
                                                        @endif
                                                    @endforeach </td>
                                                    <td><button type="button"  class="btn btn-success addRow">AJOUTER</button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-lg-6">
                                        <br><br><br><br>
                                        <table class="table  table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Quantite</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="conteneur">

                                            </tbody>
                                        </table>
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
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Ajouter un chauffeur</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom chauffeur</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="form-control"  required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                  <button type="button" class="btn btn-primary" id="jsonchauffeur" data-dismiss="modal">Ajouter</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

          <div class="modal fade" id="modal-default1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Ajouter un fournisseur</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nom fournisseur</label>
                            <input type="text" id="nomf" name="nomf"  value="{{ old('nomf') }}" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Tel fournisseur</label>
                            <input type="text" name="telf" id="telf" value="{{ old('telf') }}" class="form-control"  >
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                  <button type="button" class="btn btn-primary" id="jsonfournisseur" data-dismiss="modal">Ajouter</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
       var prixu = $("#prixu").val();
       var quantite = $("#quantite").val();
       console.log(prixu * quantite);
      });
});
$("#jsonfournisseur").click(function () {


var nomf =  $("#nomf").val();
var telf = $("#telf").val();
var fournisseur='';

    $.ajax({
        type:'POST',
           url:"{{ route('json.fournisseur.store') }}",
           data:{_token:'<?php echo csrf_token() ?>', nomf:nomf, telf:telf},
        success:function(data) {


            fournisseur ="<option value="+data.id+" selected>"+data.nomf+"</option>";

            $("#fournisseur_id").append(fournisseur);
        }
    });

});

$("#jsonchauffeur").click(function () {


    var nom =  $("#nom").val();
    var chauffeur='';

        $.ajax({
            type:'POST',
               url:"{{ route('json.chauffeur.store') }}",
               data:{_token:'<?php echo csrf_token() ?>', nom:nom},
            success:function(data) {

                chauffeur ="<option value="+data.id+" selected>"+data.nom+"</option>";

                $("#chauffeur_id").append(chauffeur);
            }
        });

    });
</script>
<script>
    $(document).ready(function () {
        $(".addRow").click(function() {
            //find content of different elements inside a row.
            var nameTxt = $(this).closest('tr').find('.name').text();
            var id = $(this).closest('tr').find('.id').text();
            $(".conteneur").append("<tr> <td><input type='hidden' value="+id+" name='produit_id[]' required>"+nameTxt+"</td>"+
            "<td><input type='number' name='quantite[]' class='form-control' min='1' required> </td>"+
            "<td><button type='button' class='btn btn-danger remove-tr'><i class='fas fa-trash'></i></button></td>");
            //alert(nameTxt);
        });
    });
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
    });


    $('.table2').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
       "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
       "info": false,
        "autoWidth": false,
        "scrollX": true,
    });
    $('.table1').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
       "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
       "info": false,
        "autoWidth": false,
        "scrollX": true,
    });

</script>
@endsection



