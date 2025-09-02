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
        Schema::create('rl_formulario4', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->unsignedBigInteger('formulario2_id');
            $table->unsignedBigInteger('configFormulado_id');
            $table->unsignedBigInteger('unidadCarrera_id');
            $table->unsignedBigInteger('areaestrategica_id');
            $table->unsignedBigInteger('gestion_id');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('bnservicio_id');
            $table->string('primer_semestre', 10);
            $table->string('segundo_semestre', 10);
            $table->string('meta_anual',10);
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();

            //relacion con formulario n2
            $table->foreign('formulario2_id')
                        ->references('id')
                        ->on('rl_formulario2')
                        ->onDelete('restrict');
            //relacion con rl_tipo
            $table->foreign('tipo_id')
                        ->references('id')
                        ->on('rl_tipo')
                        ->onDelete('restrict');
            //relacion con rl_categoria
            $table->foreign('categoria_id')
                        ->references('id')
                        ->on('rl_categoria')
                        ->onDelete('restrict');
            //relacion con rl_bienservicio
            $table->foreign('bnservicio_id')
                        ->references('id')
                        ->on('rl_bienservicio')
                        ->onDelete('restrict');
        });

        Schema::create('formulario4_unidad_res', function (Blueprint $table) {
            $table->unsignedBigInteger('formulario4_id');
            $table->unsignedBigInteger('unidad_id');

            $table->foreign('formulario4_id')
                    ->references('id')
                    ->on('rl_formulario4')
                    ->onDelete('cascade');
            $table->foreign('unidad_id')
                    ->references('id')
                    ->on('rl_unidad_carrera')
                    ->onDelete('cascade');
        });

        Schema::create('rl_asignacion_monto_form4', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulario4_id');
            $table->decimal('monto_asignado', 50, 2)->unsigned();
            $table->unsignedBigInteger('financiamiento_tipo_id');
            $table->date('fecha');

            $table->foreign('formulario4_id')
                    ->references('id')
                    ->on('rl_formulario4')
                    ->onDelete('restrict');
            $table->foreign('financiamiento_tipo_id')
                    ->references('id')
                    ->on('rl_financiamiento_tipo')
                    ->onDelete('restrict');
        });


        Schema::create('rl_historial_asignacion_monto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignacionMontof4_id');
            $table->decimal('monto', 50, 2)->unsigned();
            $table->date('fecha');

            $table->foreign('asignacionMontof4_id')
                    ->references('id')
                    ->on('rl_asignacion_monto_form4')
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
        Schema::dropIfExists('rl_formulario4');
        Schema::dropIfExists('formulario4_unidad_res');
        Schema::dropIfExists('asignacion_monto_form4');
        Schema::dropIfExists('historial_asignacion_monto');
    }
};
