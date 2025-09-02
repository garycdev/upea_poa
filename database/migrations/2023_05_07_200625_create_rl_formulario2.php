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
        Schema::create('rl_formulario2', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->unsignedBigInteger('formulario1_id');
            $table->unsignedBigInteger('configFormulado_id');
            $table->unsignedBigInteger('indicador_id');
            $table->unsignedBigInteger('gestion_id');
            $table->unsignedBigInteger('areaestrategica_id');
            $table->unsignedBigInteger('unidadCarrera_id');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();

            $table->foreign('formulario1_id')
                    ->references('id')
                    ->on('rl_formulario1')
                    ->onDelete('restrict');
            $table->foreign('indicador_id')
                    ->references('id')
                    ->on('rl_indicador')
                    ->onDelete('restrict');
        });

        //relacion CON PDU con objetivo estrategico
        Schema::create('formulario2_objEstrategico', function (Blueprint $table) {
            $table->unsignedBigInteger('formulario2_id');
            $table->unsignedBigInteger('objetivoEstrategico_id');

            $table->foreign('formulario2_id')
                    ->references('id')
                    ->on('rl_formulario2')
                    ->onDelete('cascade');
            $table->foreign('objetivoEstrategico_id')
                    ->references('id')
                    ->on('rl_objetivo_estrategico')
                    ->onDelete('cascade');
        });

        //relacion con politica de desarrollo de PDU
        Schema::create('formulario2_politicaDesarrollo_pdu', function (Blueprint $table) {
            $table->unsignedBigInteger('formulario2_id');
            $table->unsignedBigInteger('politicaDesarrollo_id');

            $table->foreign('formulario2_id')
                    ->references('id')
                    ->on('rl_formulario2')
                    ->onDelete('cascade');
            $table->foreign('politicaDesarrollo_id')
                    ->references('id')
                    ->on('rl_politica_de_desarrollo')
                    ->onDelete('cascade');
        });

        //relacion con politica de desarrollo de PEI
        Schema::create('formulario2_politicaDesarrollo_pei', function (Blueprint $table) {
            $table->unsignedBigInteger('formulario2_id');
            $table->unsignedBigInteger('politicaDesarrollo_id');

            $table->foreign('formulario2_id')
                    ->references('id')
                    ->on('rl_formulario2')
                    ->onDelete('cascade');
            $table->foreign('politicaDesarrollo_id')
                    ->references('id')
                    ->on('rl_politica_de_desarrollo')
                    ->onDelete('cascade');
        });

        //relacion con objetivo estrategico de SUB
        Schema::create('formulario2_objEstrategico_sub', function (Blueprint $table) {
            $table->unsignedBigInteger('formulario2_id');
            $table->unsignedBigInteger('objEstrategico_id');

            $table->foreign('formulario2_id')
                    ->references('id')
                    ->on('rl_formulario2')
                    ->onDelete('cascade');
            $table->foreign('objEstrategico_id')
                    ->references('id')
                    ->on('rl_objetivo_estrategico_sub')
                    ->onDelete('cascade');
        });

        //relacion con objetivo estrategico de SUB
        Schema::create('formulario2_objInstitucional', function (Blueprint $table) {
            $table->unsignedBigInteger('formulario2_id');
            $table->unsignedBigInteger('objInstitucional_id');

            $table->foreign('formulario2_id')
                    ->references('id')
                    ->on('rl_formulario2')
                    ->onDelete('cascade');
            $table->foreign('objInstitucional_id')
                    ->references('id')
                    ->on('rl_objetivo_institucional')
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
        Schema::dropIfExists('rl_formulario2');
        Schema::dropIfExists('formulario2_objEstrategico');
        Schema::dropIfExists('formulario2_politicaDesarrollo_pdu');
        Schema::dropIfExists('formulario2_politicaDesarrollo_pei');
        Schema::dropIfExists('formulario2_objEstrategico_sub');
        Schema::dropIfExists('formulario2_objInstitucional');
    }
};
