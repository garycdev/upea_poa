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
        Schema::create('rl_foda_descripcion', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->unsignedBigInteger('id_area_estrategica');
            $table->unsignedBigInteger('id_tipo_foda');
            $table->unsignedBigInteger('id_tipo_plan');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
            //relacion con areas estrategicas
            $table->foreign('id_area_estrategica')
                    ->references('id')
                    ->on('rl_areas_estrategicas')
                    ->onDelete('restrict');
            //relacion con tipo de foda
            $table->foreign('id_tipo_foda')
                    ->references('id')
                    ->on('rl_tipo_foda')
                    ->onDelete('restrict');
            //relacion con tipo de plan
            $table->foreign('id_tipo_plan')
                    ->references('id')
                    ->on('rl_tipo_plan')
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
        Schema::dropIfExists('rl_foda_descripcion');
    }
};
