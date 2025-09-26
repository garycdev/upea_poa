<?php

namespace App\Models\Configuracion_poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\Partida_tipo;
use App\Models\Clasificador\Clasificador_primero;
use App\Models\Configuracion\Formulado_tipo;
use App\Models\Gestiones;
use App\Models\Poa\Formulario1;

class Configuracion_formulado extends Model
{
    use HasFactory;
    protected $table = 'rl_configuracion_formulado';
    protected $fillable=[
        'fecha_inicial',
        'fecha_final',
        'codigo',
        'gestiones_id',
        'formulado_id',
    ];
    public $timestamps = false;

    //relacion de muchos a muchos con la tabla de rl_partida_tipo
    public function partida_tipo(){
        return $this->belongsToMany(Partida_tipo::class, 'confor_clasprim_partipo', 'configuracion_fid', 'partida_tid')->withPivot('clasificador_pid');
    }

    //relacion de muchos a muchos con la tabla de rl_partida_tipo
    public function partida_detalles(){
        return $this->belongsToMany(Partida_tipo::class, 'confor_clasprim_partipo', 'configuracion_fid', 'partida_tid')->withPivot('clasificador_pid');
    }

    //relacion de muchos a muchos con la tabla de rl_clasificador_primero
    public function clasificador_primero(){
        return $this->belongsToMany(Clasificador_primero::class, 'confor_clasprim_partipo', 'configuracion_fid', 'clasificador_pid')->withPivot('partida_tid');
    }
    //relacion reversa de con formulado_tipo
    public function formulado_tipo(){
        return $this->belongsTo(Formulado_tipo::class, 'formulado_id', 'id');
    }
    //relacion reversa con rl_gestiones
    public function gestiones(){
        return $this->belongsTo(Gestiones::class, 'gestiones_id', 'id');
    }
    //relacion con formulario1
    public function formulario1(){
        return $this->hasMany(Formulario1::class, 'configFormulado_id', 'id');
    }
    public function gestion(){
        return $this->hasOne(Gestiones::class, 'id', 'gestiones_id');
    }
}
