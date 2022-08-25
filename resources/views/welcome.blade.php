@extends('layout')
@section('title', '| produit')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">Tableau de bord</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" role="button" class="btn btn-success">ACCUEIL</a></li>
                                </ol>
                            </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
            </div>
            <div class="row">
@foreach ($stocks as $stock)
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <a href="{{ route('un.depot', ['id'=>$stock->id]) }}"><span class="info-box-text">{{  $stock->nomd}}</span></a>
        <span class="info-box-number">{{ $stock->stock }} articles</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
@endforeach
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
    <div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Rechercher un produit
            </div>

            <div class="card-body">
                <form action="{{ route('chercher.produit') }}" method="POST">
                    @csrf

                        <label>Produit</label>
                        <div class="form-group input-group input-group-sm">

                            <select class="form-control select2" id="produit_id" name="produit_id" required="">
                                <option value="">Selectionnez</option>
                                @foreach ($produits as $produit)
                                <option value="{{$produit->id}}">{{$produit->nomp}}</option>
                                    @endforeach
                            </select>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-default">Rechercher!</button>
                              </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-exchange-alt"></i></span>

              <div class="info-box-content">
                <a href="{{ route('nonvalider.transfert') }}"><span class="info-box-text">Transfert</span></a>
                <span class="info-box-number">{{ $nbTransfert }} à valider</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
@foreach ($depots as $depot )
<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center"><h4>Depot de {{ $depot->nomd }}</h4></div>
            <div class="card-body">
                <table id="example1" class="table tables table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom du produit</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($depot->depotProduits as $depotProduit)

                        <tr>
                         @if(!empty($depotProduit->produit))


                            <td>{{ $depotProduit->produit->id }}</td>
                            <td><a href="{{ route('get.chercher.produit', ['id'=>$depotProduit->produit->id]) }}">{{ $depotProduit->produit->nomp }}</a></td>
                            <td>{{ $depotProduit->stock }}</td>
                             <td>
                                {{--  <a href="{{ route('produit.edit', $depotProduit->produit->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>  --}}
                                <a href="{{ route('detail.produit', $depotProduit->produit->id) }}" role="button" class="btn btn-warning"><i class="fas fa-eye"></i></a>


                            </td>
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

        </div>
    </div>
    @endforeach
</div>

@endsection
@section('script')

<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
});
</script>
@endsection
