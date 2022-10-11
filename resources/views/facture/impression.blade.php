<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SEDIPAL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
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
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
  window.addEventListener("load", window.print());
</script>
</body>
</html>
