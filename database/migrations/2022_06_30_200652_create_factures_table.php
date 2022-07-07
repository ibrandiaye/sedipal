<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('facs');
            $table->unsignedBigInteger('chauffeur_id')->nullable();
            $table->unsignedBigInteger('depot_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('depot_id')
            ->references('id')
            ->on('depots');
            $table->foreign('client_id')
            ->references('id')
            ->on('clients');
            $table->foreign('chauffeur_id')
            ->references('id')
            ->on('chauffeurs');
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
        Schema::dropIfExists('factures');
    }
}
