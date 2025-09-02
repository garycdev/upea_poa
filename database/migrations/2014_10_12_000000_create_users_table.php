<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ci_persona', 100)->unique();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('usuario', 100);
            $table->string('password', 100);
            $table->string('estado', 20);
            $table->string('celular', 30)->nullable();
            $table->string('perfil', 100)->nullable();
            $table->string('email')->unique();
            $table->rememberToken();
            $table->timestamp('creado_el')->nullable();
            $table->timestamp('editado_el')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('id_unidad_carrera')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $consulta = User::get();
        foreach($consulta as $lis){
            if($lis->perfil != null){
                $ubicacion = public_path('perfil/'.$lis->perfil);
                unlink($ubicacion);
            }
        }
        Schema::dropIfExists('users');
    }
};
