<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Clasificador\Clasificador_primero;

class Partida_tipo extends Model
{
    use HasFactory;
    protected $table = 'rl_partida_tipo';
    protected $fillable=[
        'descripcion',
        'estado',
    ];
    public $timestamps = false;
    protected function descripcion():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
    //relacion de muchos a muchos con la tabla de rl_configuracion_formulado
    public function configuracion_formulado(){
        return $this->belongsToMany(Configuracion_formulado::class, 'confor_clasprim_partipo', 'partida_tid', 'configuracion_fid')->withPivot('clasificador_pid');
    }
    //relacion de muchos a muchos con la tabla de rl_clasificador_primero
    public function clasificador_primero(){
        return $this->belongsToMany(Clasificador_primero::class, 'confor_clasprim_partipo', 'partida_tid', 'clasificador_pid')->withPivot('configuracion_fid');
    }
}

