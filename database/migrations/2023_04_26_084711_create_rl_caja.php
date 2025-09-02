<?php

use App\Models\Admin_caja\Caja;
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
        Schema::create('rl_caja', function (Blueprint $table) {
            $table->id();
            $table->decimal('saldo', 50, 2)->unsigned();
            $table->date('fecha');
            $table->string('documento_privado', 100);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('gestiones_id');
            $table->unsignedBigInteger('unidad_carrera_id');
            $table->unsignedBigInteger('financiamiento_tipo_id');

            $table->foreign('gestiones_id')
                        ->references('id')
                        ->on('rl_gestiones')
                        ->onDelete('restrict');
            $table->foreign('unidad_carrera_id')
                        ->references('id')
                        ->on('rl_unidad_carrera')
                        ->onDelete('restrict');
            $table->foreign('financiamiento_tipo_id')
                        ->references('id')
                        ->on('rl_financiamiento_tipo')
                        ->onDelete('restrict');
        });

        Schema::create('rl_historial_caja', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('documento_privado',100)->nullable();
            $table->string('concepto');
            $table->decimal('saldo', 50, 2)->unsigned();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('caja_id');
            $table->foreign('caja_id')
                    ->references('id')
                    ->on('rl_caja')
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
        /* $consulta_primero = Caja::get();
        foreach($consulta_primero as $lis){
            $ubicacion = public_path('documento_privado/'.$lis->documento_privado);
            unlink($ubicacion);
        } */
        Schema::dropIfExists('rl_caja');
        Schema::dropIfExists('rl_historial_caja');

    }
};
