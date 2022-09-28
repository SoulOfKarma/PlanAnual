<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('run')->unique();
            $table->string('nombre_usuario');
            $table->string('apellido_usuario');
            $table->bigInteger('anexo')->nullable();
            $table->string('correo_usuario')->nullable();
            $table->string('password');
            $table->string('bodega')->nullable();
            $table->bigInteger('idServicio');
            $table->bigInteger('idEstado');         
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
