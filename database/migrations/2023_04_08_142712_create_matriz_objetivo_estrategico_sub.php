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
        Schema::create('matriz_objetivo_estrategico_sub', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id');
            $table->unsignedBigInteger('obj_estrategico_sub_id');

            $table->foreign('matriz_id')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('obj_estrategico_sub_id')
                    ->references('id')
                    ->on('rl_objetivo_estrategico_sub')
                    ->onDelete('cascade');
        });

        Schema::create('matriz_objetivo_institucional', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id');
            $table->unsignedBigInteger('obj_institucional_id');

            $table->foreign('matriz_id')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('obj_institucional_id')
                    ->references('id')
                    ->on('rl_objetivo_institucional')
                    ->onDelete('cascade');
        });

        Schema::create('matriz_politica_desarrollo_pei', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id');
            $table->unsignedBigInteger('politica_desarrollo_pei');

            $table->foreign('matriz_id')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('politica_desarrollo_pei')
                    ->references('id')
                    ->on('rl_politica_de_desarrollo')
                    ->onDelete('cascade');
        });

        Schema::create('matriz_politica_desarrollo_pdu', function (Blueprint $table) {
            $table->unsignedBigInteger('matriz_id');
            $table->unsignedBigInteger('politica_desarrollo_pdu');

            $table->foreign('matriz_id')
                    ->references('id')
                    ->on('rl_matriz_planificacion')
                    ->onDelete('cascade');
            $table->foreign('politica_desarrollo_pdu')
                    ->references('id')
                    ->on('rl_politica_de_desarrollo')
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
        Schema::dropIfExists('matriz_objetivo_estrategico_sub');
        Schema::dropIfExists('matriz_objetivo_institucional');
        Schema::dropIfExists('matriz_politica_desarrollo_pei');
        Schema::dropIfExists('matriz_politica_desarrollo_pdu');
    }
};
