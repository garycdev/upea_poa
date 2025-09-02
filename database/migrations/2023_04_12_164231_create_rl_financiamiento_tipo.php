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
        Schema::create('rl_financiamiento_tipo', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 10)->unique();
            $table->string('codigo', 10)->unique();
            $table->string('descripcion', 100);
            $table->string('estado', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rl_financiamiento_tipo');
    }
};
