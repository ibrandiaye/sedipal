@extends('layout')
@section('title', '| produit')


@section('content')

<div class="content-wrapper">
        <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-info">{{ $produit->nomp }}</h1>
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
    <div class="row">
@foreach ($depotProduits as $depotProduit)
<div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">{{ $depotProduit->depot->nomd }}</span>
        <span class="info-box-number">{{ $depotProduit->stock }} {{ $depotProduit->produit->unite }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
@endforeach
</div>
<div class="col-12">
    <div class="card border-danger border-0">
        <div class="card-header bg-success text-center"><h4>Depot de {{-- $depot->nomd --}}</h4></div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-responsive-md table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom du produit</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                   {{--   @foreach ($depot->depotProduits as $depotProduit)
                        <tr>
                            <td>{{ $depotProduit->produit->id }}</td>
                            <td>{{ $depotProduit->produit->nomp }}</td>
                            <td>{{ $depotProduit->stock }}</td>
                             <td>
                                {{--  <a href="{{ route('produit.edit', $depotProduit->produit->id) }}" role="button" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('produit.edit', $depotProduit->produit->id) }}" role="button" class="btn btn-warning"><i class="fas fa-eye"></i></a>


                            </td>

                        </tr>
                        @endforeach  --}}

                    </tbody>
                </table>



            </div>

        </div>
    </div>
</div>

@endsection

