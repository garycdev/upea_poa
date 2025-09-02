<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_tipo;
use App\Models\Clasificador\Clasificador_segundo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion\Partida_tipo;
use App\Models\Configuracion_poa\Configuracion_formulado;

class Clasificador_primero extends Model
{
    use HasFactory;
    protected $table = 'rl_clasificador_primero';
    protected $fillable=[
        'codigo',
        'titulo',
        'descripcion',
        'estado',
        'id_clasificador_tipo',
        'id_gestion',
    ];
    public $timestamps = false;

    protected function titulo():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }


    //relacion con rl_calsificador_segundo
    public function relacion_clasificador_segundo(){
        return $this->hasMany(Clasificador_segundo::class, 'id_clasificador_primero', 'id');
    }

    //relacion reversa con rl_clasificador_tipo
    public function clasificador_tipo(){
        return $this->belongsTo(Clasificador_tipo::class, 'id_clasificador_tipo', 'id');
    }

    //relacion de muchos a muchos con la tabla de rl_partida_tipo
    public function partida_tipo(){
        return $this->belongsToMany(Partida_tipo::class, 'confor_clasprim_partipo', 'clasificador_pid', 'partida_tid')->withPivot('configuracion_fid');
    }
    //relacion de muchos a muchos con la tabla de rl_configuracion_formulado
    public function configuracion_formulado(){
        return $this->belongsToMany(Configuracion_formulado::class, 'confor_clasprim_partipo', 'clasificador_pid', 'configuracion_fid')->withPivot('partida_tid');
    }
}
