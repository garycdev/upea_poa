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
        Schema::create('rl_articulacion_pdes', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_eje');
            $table->text('descripcion_eje');
            $table->string('codigo_meta',6);
            $table->text('descripcion_meta');
            $table->string('codigo_resultado', 10);
            $table->text('descripcion_resultado');
            $table->string('codigo_accion',8);
            $table->text('descripcion_accion');
            $table->unsignedBigInteger('id_gestion')->unique();
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
            $table->foreign('id_gestion')
                    ->references('id')
                    ->on('rl_gestion')
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
        Schema::dropIfExists('rl_articulacion_pdes');
    }
};
