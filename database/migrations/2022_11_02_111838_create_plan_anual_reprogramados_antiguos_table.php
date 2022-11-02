<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanAnualReprogramadosAntiguosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_anual_reprogramados_antiguos', function (Blueprint $table) {
            $table->id();
            $table->string('CODART')->nullable();
            $table->string('NOMART')->nullable();
            $table->string('UNIMED')->nullable();
            $table->float('PRECIO')->nullable();
            $table->bigInteger('C_ENE')->nullable();
            $table->bigInteger('C_FEB')->nullable();
            $table->bigInteger('C_MAR')->nullable();
            $table->bigInteger('C_ABR')->nullable();
            $table->bigInteger('C_MAY')->nullable();
            $table->bigInteger('C_JUN')->nullable();
            $table->bigInteger('C_JUL')->nullable();
            $table->bigInteger('C_AGO')->nullable();
            $table->bigInteger('C_SEP')->nullable();
            $table->bigInteger('C_OCT')->nullable();
            $table->bigInteger('C_NOV')->nullable();
            $table->bigInteger('C_DIC')->nullable();
            $table->float('C_TOTAL',15,2)->nullable();
            $table->float('T_PRECIO',15,2)->nullable();
            $table->date('FECING')->nullable();
            $table->string('CODSER')->nullable();
            $table->string('NOMSER')->nullable();
            $table->string('BODEGA')->nullable();
            $table->string('OBS')->nullable();
            $table->string('ANIO')->nullable();
            $table->string('NROPED')->nullable();
            $table->string('idServicio')->nullable();
            $table->string('ZGEN')->nullable();
            $table->bigInteger('idReprogramado');
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
        Schema::dropIfExists('plan_anual_reprogramados_antiguos');
    }
}
