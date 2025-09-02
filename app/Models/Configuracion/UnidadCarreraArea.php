<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pei\Matriz_planificacion;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Admin_caja\Caja;

class UnidadCarreraArea extends Model
{
    use HasFactory;
    protected $table = 'rl_unidad_carrera';

    protected $fillable=[
        'nombre_completo',
        'estado',
        'id_tipo_carrera'
    ];
    public $timestamps = false;

    protected function nombrecompleto():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => $value
        );
    }
    //relacion reversa de tipo carrrera, unidad administrativa o area
    public function tipo_Carrera_UnidadaArea(){
        return $this->belongsTo(Tipo_CarreraUnidad::class, 'id_tipo_carrera', 'id');
    }


    //relacion de muchos a muchos con matriz de planificacion
    public function matriz_planificacion(){
        return $this->belongsToMany(Matriz_planificacion::class, 'matriz_unidad_inv', 'unidad_id_inv', 'matriz_id_inv');
    }

    //relacion de uno a muchos con caja
    public function relacion_caja(){
        return $this->hasMany(Caja::class, 'unidad_carrera_id', 'id');
    }
}
