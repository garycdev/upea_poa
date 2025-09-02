<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Medida_bienservicio;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Operacion;

class Formulario5 extends Model
{
    use HasFactory;
    protected $table = 'rl_formulario5';
    protected $fillable=[
        'formulario4_id',
        'operacion_id',
        'configFormulado_id',
        'areaestrategica_id',
        'unidadCarrera_id',
        'gestion_id',
        'primer_semestre',
        'segundo_semestre',
        'total',
        'desde',
        'hasta',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
    //relacion de uno a muchos con rl_formulario5
    public function medida_bien_serviciof5(){
        return $this->hasMany(Medida_bienservicio::class, 'formulario5_id', 'id');
    }
    //relacion reversa de formulario4
    public function formulario4(){
        return $this->belongsTo(Formulario4::class, 'formulario4_id', 'id');
    }
    //reversa con rl_operacion
    public function operacion(){
        return $this->belongsTo(Operacion::class, 'operacion_id', 'id');
    }
}
