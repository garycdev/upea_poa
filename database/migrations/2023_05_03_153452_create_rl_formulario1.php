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
        Schema::create('rl_formulario1', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('maxima_autoridad');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('gestion_id');
            $table->unsignedBigInteger('configFormulado_id');
            $table->unsignedBigInteger('unidadCarrera_id');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
            $table->foreign('configFormulado_id')
                    ->references('id')
                    ->on('rl_configuracion_formulado')
                    ->onDelete('restrict');
        });

        Schema::create('areaestrategica_formulario1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('areEstrategica_id');
            $table->unsignedBigInteger('formulario1_id');

            $table->foreign('areEstrategica_id')
                    ->references('id')
                    ->on('rl_areas_estrategicas')
                    ->onDelete('cascade');
            $table->foreign('formulario1_id')
                    ->references('id')
                    ->on('rl_formulario1')
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
        Schema::dropIfExists('rl_formulario1');
        Schema::dropIfExists('areaestrategica_formulario1');
    }
};
