<?php

namespace App\Models\Poa;

use App\Models\Areas_estrategicas;
use App\Models\Pdu\Objetivo_estrategico;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Indicador;
use App\Models\Pei\Objetivo_estrategico_sub;
use App\Models\Pei\Objetivo_institucional;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Formulario1;

class Formulario2 extends Model
{
    use HasFactory;
    protected $table = 'rl_formulario2';
    protected $fillable=[
        'codigo',
        'formulario1_id',
        'configFormulado_id',
        'indicador_id',
        'gestion_id',
        'areaestrategica_id',
        'unidadCarrera_id',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
    //relacion reversa con Formulario 1
    public function formulario1(){
        return $this->belongsTo(Formulario1::class, 'formulario1_id', 'id');
    }
    //relacion reversa del indicador
    public function indicador(){
        return $this->belongsTo(Indicador::class, 'indicador_id', 'id');
    }

    //relacion de muchos a muchos formulario2_politicaDesarrollo_pdu
    public function politica_desarrollo_pdu(){
        return $this->belongsToMany(Politica_desarrollo::class, 'formulario2_politicaDesarrollo_pdu', 'formulario2_id', 'politicaDesarrollo_id');
    }
    //relacion de muchos a muchos formulario2_objEstrategico
    public function objetivo_estrategico(){
        return $this->belongsToMany(Objetivo_estrategico::class, 'formulario2_objEstrategico', 'formulario2_id', 'objetivoEstrategico_id');
    }
    //relacion de muchos a muchos formulario2_politicaDesarrollo_pei
    public function politica_desarrollo_pei(){
        return $this->belongsToMany(Politica_desarrollo::class, 'formulario2_politicaDesarrollo_pei', 'formulario2_id', 'politicaDesarrollo_id');
    }
    //relacion de muchos a muchos formulario2_objEstrategico_sub
    public function objetivo_estrategico_sub(){
        return $this->belongsToMany(Objetivo_estrategico_sub::class, 'formulario2_objEstrategico_sub', 'formulario2_id', 'objEstrategico_id');
    }
    //relacion de muchos a muchos formulario2_objInstitucional
    public function objetivo_institucional(){
        return $this->belongsToMany(Objetivo_institucional::class, 'formulario2_objInstitucional', 'formulario2_id', 'objInstitucional_id');
    }
    //relacion con formulario2 uno a uno // o uno a muchos
    public function formulario4(){
        return $this->hasMany(Formulario4::class, 'formulario2_id', 'id');
    }

    ///relacion con areas estrategicas
    public function areas_estrategicas(){
        return $this->belongsTo(Areas_estrategicas::class, 'areaestrategica_id', 'id');
    }
}
