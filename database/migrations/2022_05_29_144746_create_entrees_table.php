<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('depot_id');
            $table->integer('quantite');
            $table->double('prixu');
            $table->unsignedBigInteger('fournisseur_id');
            $table->integer('stock');
            $table->foreign('produit_id')
            ->references('id')
            ->on('produits');
            $table->foreign('depot_id')
            ->references('id')
            ->on('depots');
            $table->foreign('fournisseur_id')
            ->references('id')
            ->on('fournisseurs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrees');
    }
}
