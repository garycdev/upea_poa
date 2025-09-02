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
        Schema::create('rl_gestiones', function (Blueprint $table) {
            $table->id();
            $table->year('gestion');
            $table->text('estado', 20);
            $table->unsignedBigInteger('id_gestion');
            $table->foreign('id_gestion')->references('id')
                    ->on('rl_gestion')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('rl_gestiones');
    }
};
