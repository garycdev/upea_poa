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
    public function up(){
        Schema::create('matriz_unidad_res', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id_res');
            $table->unsignedBigInteger('unidad_id_res');

            $table->foreign('matriz_id_res')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('unidad_id_res')
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
    public function down(){
        Schema::dropIfExists('matriz_unidad_res');
    }
};
