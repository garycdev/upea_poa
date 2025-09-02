<?php

namespace App\Models\Poa;

use App\Models\Areas_estrategicas;
use App\Models\Configuracion\Cargo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Poa\Formulario2;

class Formulario1 extends Model
{
    use HasFactory;
    protected $table = 'rl_formulario1';
    protected $fillable=[
        'fecha',
        'maxima_autoridad',
        'usuario_id',
        'gestion_id',
        'configFormulado_id',
        'unidadCarrera_id',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
    //relacion de muchos a muchos con areas estrategicas
    public function relacion_areasEstrategicas(){
        return $this->belongsToMany(Areas_estrategicas::class, 'areaestrategica_formulario1', 'formulario1_id', 'areEstrategica_id');
    }

    //relacion reversa con rl_confiuguracion_formulado
    public function configuracion_formulado(){
        return $this->belongsTo(Configuracion_formulado::class, 'configFormulado_id', 'id');
    }

    //relacion con el formulario1
    public function formulario2(){
        return $this->hasMany(Formulario2::class, 'formulario1_id', 'id');
    }
}
