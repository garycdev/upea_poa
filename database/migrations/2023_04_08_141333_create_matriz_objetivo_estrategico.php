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
        Schema::create('matriz_objetivo_estrategico', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id');
            $table->unsignedBigInteger('objetivo_estrategico_id');

            $table->foreign('matriz_id')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('objetivo_estrategico_id')
                    ->references('id')
                    ->on('rl_objetivo_estrategico')
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
        Schema::dropIfExists('matriz_objetivo_estrategico');
    }
};
