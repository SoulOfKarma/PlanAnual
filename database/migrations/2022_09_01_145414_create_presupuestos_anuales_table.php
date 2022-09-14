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
            $table->string('ANIO')->nullable();
            $table->bigInteger('P_ANUAL')->nullable();
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
