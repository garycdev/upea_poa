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
        Schema::create('rl_formulario5', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulario4_id');
            $table->unsignedBigInteger('operacion_id');
            $table->unsignedBigInteger('configFormulado_id');
            $table->unsignedBigInteger('unidadCarrera_id');
            $table->unsignedBigInteger('areaestrategica_id');
            $table->unsignedBigInteger('gestion_id');
            $table->string('primer_semestre',10);
            $table->string('segundo_semestre',10);
            $table->string('total',10);
            $table->date('desde');
            $table->date('hasta');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
            $table->foreign('formulario4_id')
                    ->references('id')
                    ->on('rl_formulario4')
                    ->onDelete('restrict');
            $table->foreign('operacion_id')
                    ->references('id')
                    ->on('rl_operaciones')
                    ->onDelete('restrict');
        });

        Schema::create('rl_medida', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });

        Schema::create('rl_medida_bienservicio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulario5_id');
            $table->unsignedBigInteger('medida_id');
            $table->string('cantidad', 20)->nullable();
            $table->string('precio_unitario',50)->nullable();
            $table->decimal('total_presupuesto', 50, 2)->unsigned()->nullable();
            $table->unsignedBigInteger('tipo_financiamiento_id');
            $table->date('fecha_requerida');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();

            $table->foreign('formulario5_id')
                    ->references('id')
                    ->on('rl_formulario5')
                    ->onDelete('restrict');

            $table->foreign('medida_id')
                    ->references('id')
                    ->on('rl_medida')
                    ->onDelete('restrict');

            $table->foreign('tipo_financiamiento_id')
                    ->references('id')
                    ->on('rl_financiamiento_tipo')
                    ->onDelete('restrict');

        });


        //relaciones de muchos a muchos
        Schema::create('detalleTercerClasi_medida_bn', function (Blueprint $table) {
            $table->unsignedBigInteger('detalle_tercerclasif_id');
            $table->unsignedBigInteger('medidabn_id');
//            $table->foreign('detalle_tercerclasif_id')
//                    ->references('id')
//                    ->on('rl_detalleclasitercero')
//                    ->onDelete('cascade');
//            $table->foreign('medidabn_id')
//                    ->references('id')
//                    ->on('rl_medida_bienservicio')
//                    ->onDelete('cascade');
        });

        //relaciones de muchos a muchos
        Schema::create('detalleCuartoClasi_medida_bn', function (Blueprint $table) {
            $table->unsignedBigInteger('detalle_cuartoclasif_id');
            $table->unsignedBigInteger('medidabn_id');
/*            $table->foreign('detalle_cuartoclasif_id')
                    ->references('id')
                    ->on('rl_detalleclasicuarto')
                    ->onDelete('cascade');
            $table->foreign('medidabn_id')
                    ->references('id')
                    ->on('rl_medida_bienservicio')
                    ->onDelete('cascade');*/
        });

        //relaciones de muchos a muchos
        Schema::create('detalleQuintoClasi_medida_bn', function (Blueprint $table) {
            $table->unsignedBigInteger('detalle_quintoclasif_id');
            $table->unsignedBigInteger('medidabn_id');
/*            $table->foreign('detalle_quintoclasif_id')
                    ->references('id')
                    ->on('rl_detalleclasiquinto')
                    ->onDelete('cascade');
            $table->foreign('medidabn_id')
                    ->references('id')
                    ->on('rl_medida_bienservicio')
                    ->onDelete('cascade');*/
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rl_formulario5');
        Schema::dropIfExists('rl_medida_bienservicio');
        Schema::dropIfExists('rl_medida');
        Schema::dropIfExists('detalleTercerClasi_medida_bn');
        Schema::dropIfExists('detalleCuartoClasi_medida_bn');
        Schema::dropIfExists('detalleQuintoClasi_medida_bn');
    }
};
