<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */



    public function up(){
        Schema::create('rl_areas_estrategicas', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo_areas_estrategicas');
            $table->text('descripcion');
            $table->string('estado',20);
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_gestion');
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
            $table->foreign('id_gestion')
                    ->references('id')
                    ->on('rl_gestion')
                    ->onDelete('restrict');
        });

        Schema::create('tri_areas_estrategicas', function(Blueprint $table){
            $table->id();
            $table->string('accion');
            $table->unsignedBigInteger('id_area_estrategica');
            $table->integer('ant_codigo_area_estrategica');
            $table->text('ant_descripcion');
            $table->string('ant_estado');
            $table->unsignedBigInteger('ant_id_usuario');
            $table->unsignedBigInteger('ant_id_gestion');

            $table->integer('nuevo_codigo_area_estrategica')->nullable();
            $table->text('nuevo_descripcion')->nullable();
            $table->string('nuevo_estado')->nullable();
            $table->unsignedBigInteger('nuevo_id_usuario')->nullable();
            $table->unsignedBigInteger('nuevo_id_gestion')->nullable();
            $table->timestamp('fecha');
        });


        DB::statement("CREATE TRIGGER update_tri_areas_estrategicas BEFORE UPDATE
            ON rl_areas_estrategicas FOR EACH ROW
            BEGIN
                INSERT INTO tri_areas_estrategicas(accion, id_area_estrategica, ant_codigo_area_estrategica, ant_descripcion, ant_estado, ant_id_usuario, ant_id_gestion, nuevo_codigo_area_estrategica, nuevo_descripcion, nuevo_estado, nuevo_id_usuario, nuevo_id_gestion, fecha)
                VALUES('EDITADO', OLD.id, OLD.codigo_areas_estrategicas, OLD.descripcion, OLD.estado, OLD.id_usuario, OLD.id_gestion, NEW.codigo_areas_estrategicas, NEW.descripcion, NEW.estado, NEW.id_usuario, NEW.id_gestion, NOW());
            END;
        ");

        DB::statement("CREATE TRIGGER delete_tri_areas_estrategicas AFTER DELETE
            ON rl_areas_estrategicas FOR EACH ROW
            BEGIN
                INSERT INTO tri_areas_estrategicas(accion, id_area_estrategica, ant_codigo_area_estrategica, ant_descripcion, ant_estado, ant_id_usuario, ant_id_gestion, nuevo_codigo_area_estrategica, nuevo_descripcion, nuevo_estado, nuevo_id_usuario, nuevo_id_gestion, fecha)
                VALUES('ELIMINADO', OLD.id, OLD.codigo_areas_estrategicas, OLD.descripcion, OLD.estado, OLD.id_usuario, OLD.id_gestion, NULL, NULL, NULL, NULL, NULL, NOW());
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        DB::statement('DROP TRIGGER IF EXISTS update_tri_areas_estrategicas');
        DB::statement('DROP TRIGGER IF EXISTS delete_tri_areas_estrategicas');
        Schema::dropIfExists('rl_areas_estrategicas');
        Schema::dropIfExists('tri_areas_estrategicas');

    }
};
