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
        Schema::create('rl_matriz_planificacion', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->unsignedBigInteger('id_area_estrategica');
            /* $table->unsignedBigInteger('id_pol_desarrollo_pdu');
            $table->unsignedBigInteger('id_obj_estrategico_pdu');
            $table->unsignedBigInteger('id_pol_institucional_pei');
            $table->unsignedBigInteger('id_obj_sub');
            $table->unsignedBigInteger('id_obj_institucional'); */
            $table->unsignedBigInteger('id_indicador');
            $table->unsignedBigInteger('id_tipo');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_resultado_producto');
            $table->string('linea_base', 5);
            $table->string('gestion_1', 5);
            $table->string('gestion_2', 5);
            $table->string('gestion_3', 5);
            $table->string('gestion_4', 5);
            $table->string('gestion_5', 5);
            $table->string('meta_mediano_plazo', 10);
            $table->unsignedBigInteger('id_programa_proy');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();

            /* $table->foreign('id_pol_desarrollo_pdu')
                    ->references('id')
                    ->on('rl_politica_de_desarrollo')
                    ->onDelete('restrict'); */
            /* $table->foreign('id_obj_estrategico_pdu')
                    ->references('id')
                    ->on('rl_objetivo_estrategico')
                    ->onDelete('restrict'); */
            /* $table->foreign('id_pol_institucional_pei')
                    ->references('id')
                    ->on('rl_politica_de_desarrollo')
                    ->onDelete('restrict');
            $table->foreign('id_obj_sub')
                    ->references('id')
                    ->on('rl_objetivo_estrategico_sub')
                    ->onDelete('restrict'); */
            /* $table->foreign('id_obj_institucional')
                    ->references('id')
                    ->on('rl_objetivo_institucional')
                    ->onDelete('restrict'); */
            $table->foreign('id_indicador')
                    ->references('id')
                    ->on('rl_indicador')
                    ->onDelete('restrict');
            $table->foreign('id_tipo')
                    ->references('id')
                    ->on('rl_tipo')
                    ->onDelete('restrict');
            $table->foreign('id_categoria')
                    ->references('id')
                    ->on('rl_categoria')
                    ->onDelete('restrict');
            $table->foreign('id_resultado_producto')
                    ->references('id')
                    ->on('rl_resultado_producto')
                    ->onDelete('restrict');
            $table->foreign('id_programa_proy')
                    ->references('id')
                    ->on('rl_programa_proy_acc_est')
                    ->onDelete('restrict');
            $table->foreign('id_area_estrategica')
                    ->references('id')
                    ->on('rl_areas_estrategicas')
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
        Schema::dropIfExists('rl_matriz_planificacion');
    }
};
