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
        Schema::create('rl_tipo_operacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
        });

        Schema::create('rl_operaciones', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->unsignedBigInteger('area_estrategica_id');
            $table->unsignedBigInteger('tipo_operacion_id');
            $table->foreign('tipo_operacion_id')
                    ->references('id')
                    ->on('rl_tipo_operacion')
                    ->onDelete('restrict');
            $table->foreign('area_estrategica_id')
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
        Schema::dropIfExists('rl_tipo_operacion');
        Schema::dropIfExists('rl_operaciones');
    }
};
