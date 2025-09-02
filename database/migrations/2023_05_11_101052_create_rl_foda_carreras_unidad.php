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
        Schema::create('rl_foda_carreras_unidad', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->string('estado', 20);
            $table->unsignedBigInteger('tipo_foda_id');
            $table->unsignedBigInteger('gestion_id');
            $table->unsignedBigInteger('UnidadCarrera_id');
            $table->unsignedBigInteger('usuario_id');

            $table->foreign('tipo_foda_id')
                        ->references('id')
                        ->on('rl_tipo_foda')
                        ->onDelete('restrict');
            $table->foreign('gestion_id')
                        ->references('id')
                        ->on('rl_gestiones')
                        ->onDelete('restrict');
            /* $table->foreign('UnidadCarrera_id')
                        ->references('id')
                        ->on('rl_unidad_carrera')
                        ->onDelete('restrict'); */
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rl_foda_carreras_unidad');
    }
};
