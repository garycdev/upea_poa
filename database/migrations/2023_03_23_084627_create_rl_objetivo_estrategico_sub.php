<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(){
        Schema::create('rl_objetivo_estrategico_sub', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->text('descripcion');
            $table->unsignedBigInteger('id_politica_desarrollo');
            $table->foreign('id_politica_desarrollo')
                        ->references('id')
                        ->on('rl_politica_de_desarrollo')
                        ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('rl_objetivo_estrategico_sub');
    }
};
