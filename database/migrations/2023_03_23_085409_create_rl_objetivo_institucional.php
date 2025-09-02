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
    public function up(){
        Schema::create('rl_objetivo_institucional', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->text('descripcion');
            $table->unsignedBigInteger('id_objetivo_estrategico_sub');
            $table->foreign('id_objetivo_estrategico_sub')
                        ->references('id')
                        ->on('rl_objetivo_estrategico_sub')
                        ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('rl_objetivo_institucional');
    }
};
