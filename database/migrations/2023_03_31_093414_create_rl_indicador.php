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
        Schema::create('rl_indicador', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->text('descripcion');
            $table->string('estado', 20);
            $table->unsignedBigInteger('id_gestion');
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
        Schema::dropIfExists('rl_indicador');
    }
};
