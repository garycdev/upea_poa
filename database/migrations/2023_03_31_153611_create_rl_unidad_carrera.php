<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rl_tipo_carrera', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
        });

        Schema::create('rl_unidad_carrera', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo')->unique();
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_tipo_carrera');
            $table->foreign('id_tipo_carrera')
                    ->references('id')
                    ->on('rl_tipo_carrera')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rl_tipo_carrera'); //
        Schema::dropIfExists('rl_unidad_carrera');
    }
};
