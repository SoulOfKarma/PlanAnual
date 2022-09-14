<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiabArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siab_articulos', function (Blueprint $table) {
            $table->id();
            $table->string('CODART')->nullable();
            $table->string('NOMBRE')->nullable();
            $table->string('UNIMED')->nullable();
            $table->bigInteger('PRECIO')->nullable();
            $table->bigInteger('idEstado')->nullable();
            $table->bigInteger('idBodega')->nullable();
            $table->string('NOMFAM1')->nullable();
            $table->string('NOMFAM2')->nullable();
            $table->string('NOMFAM3')->nullable();
            $table->string('NOMFAM4')->nullable();
            $table->string('NOMFAM5')->nullable();
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
        Schema::dropIfExists('siab_articulos');
    }
}
