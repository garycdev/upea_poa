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
        Schema::create('rl_politica_de_desarrollo', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->text('descripcion');
            $table->unsignedBigInteger('id_area_estrategica');
            $table->unsignedBigInteger('id_tipo_plan');
            $table->foreign('id_area_estrategica')
                        ->references('id')
                        ->on('rl_areas_estrategicas')
                        ->onDelete('restrict');
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
        Schema::dropIfExists('rl_politica_de_desarrollo');
    }
};
