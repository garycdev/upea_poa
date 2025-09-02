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
        Schema::create('rl_configuracion_formulado', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->char('codigo', 10 );
            $table->unsignedBigInteger('gestiones_id')->nullable();
            $table->unsignedBigInteger('formulado_id')->nullable();
            $table->string('estado')->nullable();
            /* $table->unsignedBigInteger('partida_id')->nullable(); */

            $table->foreign('gestiones_id')
                    ->references('id')
                    ->on('rl_gestiones')
                    ->onDelete('restrict');
            $table->foreign('formulado_id')
                    ->references('id')
                    ->on('rl_formulado_tipo')
                    ->onDelete('restrict');
            /* $table->foreign('partida_id')
                    ->references('id')
                    ->on('rl_partida_tipo')
                    ->onDelete('restrict'); */
        });

        Schema::create('confor_clasprim_partipo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partida_tid');
            $table->unsignedBigInteger('clasificador_pid');
            $table->unsignedBigInteger('configuracion_fid');

            $table->foreign('partida_tid')
                        ->references('id')
                        ->on('rl_partida_tipo')
                        ->onDelete('cascade');
            $table->foreign('clasificador_pid')
                        ->references('id')
                        ->on('rl_clasificador_primero')
                        ->onDelete('cascade');
            $table->foreign('configuracion_fid')
                        ->references('id')
                        ->on('rl_configuracion_formulado')
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
        Schema::dropIfExists('rl_configuracion_formulado');
        Schema::dropIfExists('confor_clasprim_partipo');
    }
};
