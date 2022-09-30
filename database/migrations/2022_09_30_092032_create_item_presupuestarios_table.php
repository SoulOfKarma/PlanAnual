<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPresupuestariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_presupuestarios', function (Blueprint $table) {
            $table->id();
            $table->string('CODART')->nullable();
            $table->string('NOMBRE')->nullable();
            $table->string('UNIMED')->nullable();
            $table->string('CODIPRE')->nullable();
            $table->string('NOMBREIPRE')->nullable();
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
        Schema::dropIfExists('item_presupuestarios');
    }
}
