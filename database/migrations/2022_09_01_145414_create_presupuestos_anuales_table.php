<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosAnualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos_anuales', function (Blueprint $table) {
            $table->id();
            $table->string('CODSER')->nullable();
            $table->string('NOMSER')->nullable();
            $table->string('BODEGA')->nullable();
            $table->string('ANIO')->nullable();
            $table->bigInteger('P_ANUAL')->nullable();
            $table->bigInteger('P_ENE')->nullable();
            $table->bigInteger('P_FEB')->nullable();
            $table->bigInteger('P_MAR')->nullable();
            $table->bigInteger('P_ABR')->nullable();
            $table->bigInteger('P_MAY')->nullable();
            $table->bigInteger('P_JUN')->nullable();
            $table->bigInteger('P_JUL')->nullable();
            $table->bigInteger('P_AGO')->nullable();
            $table->bigInteger('P_SEP')->nullable();
            $table->bigInteger('P_OCT')->nullable();
            $table->bigInteger('P_NOV')->nullable();
            $table->bigInteger('P_DIC')->nullable();
            $table->string('CODSERN')->nullable();
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
        Schema::dropIfExists('presupuestos_anuales');
    }
}
