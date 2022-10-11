@extends('layout')
@section('title', '| facture')


@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Invoice</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Facture</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">



          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> SEDIPAL.
                  <small class="float-right">Date:  {{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">

              <div class="col-sm-4 invoice-col">
                Client
                <address>
                <strong> {{ $facture->client->nomc }} </strong>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Facture #{{ $facture->facs  }}</b><br>
                <br>
                <b>Numéro de commande:</b> N°{{ $facture->id }}<br>
                <b>Date Facture:</b> {{  Carbon\Carbon::parse( $facture->created_at)->format('d-m-Y H:i') }}<br>
                <b>Compte:</b> {{ $facture->client->telc }}
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>

                  <tr>
                    <th>Article</th>
                    <th>Quantite commandée</th>
                    <th>Quantite Livrée</th>
                    <th>Retour</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($facture->sorties as $sortie)
                  <tr>
                    <td><a href="{{ route('get.chercher.produit', ['id'=>$sortie->produit->id]) }}">{{ $sortie->produit->nomp }}</a></td>
                        <td>
                            @php
                            $quant = 0;
                            foreach ($sortie->retours as $retour){
                                $quant = $retour->quantite + $quant;
                            }
                            $quant = $quant + $sortie->quantite;
                            if($quant > 0)
                                echo $quant;
                            else
                                echo $sortie->quantite;
                            @endphp

                        </td>
                        <td>{{ $sortie->quantite }}</td>
                    <td>
                        @foreach ($sortie->retours as $retour)
                                    Quantite : {{ $retour->quantite }},<br>
                                    Montant : {{ $retour->quantite * $sortie->produit->prixu }}<br>
                                @endforeach
                    </td>
                  </tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">


              </div>
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{ route('facture.impression', ['facture_id'=>$facture->id]) }}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection

