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
        Schema::create('rl_clasificador_tipo', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->unique();
            $table->text('descripcion');
            $table->string('estado', 20);
        });

        Schema::create('rl_clasificador_primero', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('estado',20);
            $table->unsignedBigInteger('id_clasificador_tipo');
            //$table->unsignedBigInteger('id_gestiones');

            $table->foreign('id_clasificador_tipo')
                        ->references('id')
                        ->on('rl_clasificador_tipo')
                        ->onDelete('restrict');
            /* $table->foreign('id_gestiones')
                        ->references('id')
                        ->on('rl_gestiones')
                        ->onDelete('restrict'); */
        });
        Schema::create('rl_clasificador_segundo', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_clasificador_primero');
            $table->foreign('id_clasificador_primero')
                        ->references('id')
                        ->on('rl_clasificador_primero')
                        ->onDelete('restrict');
        });
        Schema::create('rl_clasificador_tercero', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_clasificador_segundo');
            $table->foreign('id_clasificador_segundo')
                        ->references('id')
                        ->on('rl_clasificador_segundo')
                        ->onDelete('restrict');
        });
        Schema::create('rl_clasificador_cuarto', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_clasificador_tercero');
            $table->foreign('id_clasificador_tercero')
                        ->references('id')
                        ->on('rl_clasificador_tercero')
                        ->onDelete('restrict');
        });
        Schema::create('rl_clasificador_quinto', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_clasificador_cuarto');
            $table->foreign('id_clasificador_cuarto')
                        ->references('id')
                        ->on('rl_clasificador_cuarto')
                        ->onDelete('restrict');
        });

        //detalles de clasificador tercero
        Schema::create('rl_detalleClasiTercero', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->text('descripcion')->nullable();
            $table->string('estado', 20);
            $table->unsignedBigInteger('tercerclasificador_id');
            $table->foreign('tercerclasificador_id')
                        ->references('id')
                        ->on('rl_clasificador_tercero')
                        ->onDelete('restrict');
        });

        //detalles del clasificador cuarto
        Schema::create('rl_detalleClasiCuarto', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->text('descripcion')->nullable();
            $table->string('estado', 20);
            $table->unsignedBigInteger('cuartoclasificador_id');
            $table->foreign('cuartoclasificador_id')
                        ->references('id')
                        ->on('rl_clasificador_cuarto')
                        ->onDelete('restrict');
        });

        //detalles del clasificador Quinto
        Schema::create('rl_detalleClasiQuinto', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->text('descripcion')->nullable();
            $table->string('estado', 20);
            $table->unsignedBigInteger('quintoclasificador_id');
            $table->foreign('quintoclasificador_id')
                        ->references('id')
                        ->on('rl_clasificador_quinto')
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
        Schema::dropIfExists('rl_clasificador_tipo');
        Schema::dropIfExists('rl_clasificador_primero');
        Schema::dropIfExists('rl_clasificador_segundo');
        Schema::dropIfExists('rl_clasificador_tercero');
        Schema::dropIfExists('rl_clasificador_cuarto');
        Schema::dropIfExists('rl_clasificador_quinto');

        Schema::dropIfExists('rl_detalleClasiTercero');
        Schema::dropIfExists('rl_detalleClasiCuarto');

    }
};
