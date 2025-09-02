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
        Schema::create('matriz_unidad_inv', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id_inv');
            $table->unsignedBigInteger('unidad_id_inv');

            $table->foreign('matriz_id_inv')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('unidad_id_inv')
                    ->references('id')
                    ->on('rl_unidad_carrera')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriz_unidad_inv');
    }
};
