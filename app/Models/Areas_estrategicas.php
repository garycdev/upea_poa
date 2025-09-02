<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Gestion;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Foda_descripcion;
use App\Models\Pei\Matriz_planificacion;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Operacion;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Areas_estrategicas extends Model
{
    use HasFactory;
    protected $table = 'rl_areas_estrategicas';
    protected $primaryKey = 'id';

    protected $fillable=[
        'codigo_areas_estrategicas',
        'descripcion',
        'estado',
        'id_usuario',
        'id_gestion',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    protected function descripcion():Attribute{
        return new Attribute(
            get: fn ($value) => mb_strtoupper($value)
        );
    }

    //relacion en reversa con gestion
    public function reversa_relacion_areas_estrategicas(){
        return $this->belongsTo(Gestion::class, 'id_gestion', 'id');
    }

    //relacion con foda descripcion
    public function relacion_foda_descripcion(){
        return $this->hasMany(Foda_descripcion::class, 'id_area_estrategica', 'id');
    }

    //relacion con politica_desarrollo
    public function relacion_politica_desarrollo(){
        return $this->hasMany(Politica_desarrollo::class, 'id_area_estrategica', 'id')->orderBy('codigo', 'asc');
    }
    //relacion de muchos a muchos con formulario1
    public function relacion_formulario1(){
        return $this->belongsToMany(Formulario1::class, 'areaestrategica_formulario1', 'areEstrategica_id', 'formulario1_id');
    }

    //relacion con la matriz de planificacion
    public function matriz_planificacion(){
        return $this->hasMany(Matriz_planificacion::class, 'id_area_estrategica', 'id');
    }
    //
    public function operaciones(){
        return $this->hasMany(Operacion::class, 'area_estrategica_id', 'id');
    }
}
