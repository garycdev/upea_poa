<?php

namespace App\Models\Poa;

use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\Categoria;
use App\Models\Configuracion\Tipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario5;
use App\Models\Poa\BienNServicio;
use App\Models\Poa\Asignacion_montof4;
use App\Models\Configuracion\UnidadCarreraArea;

class Formulario4 extends Model
{
    use HasFactory;
    protected $table = 'rl_formulario4';
    protected $fillable=[
        'codigo',
        'formulario2_id',
        'configFormulado_id',
        'unidadCarrera_id',
        'areaestrategica_id',
        'gestion_id',
        'tipo_id',
        'categoria_id',
        'bnservicio_id',
        'primer_semestre',
        'segundo_semestre',
        'meta_anual',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa de uno a uno con formulario2
    public function formulario2(){
        return $this->belongsTo(Formulario2::class, 'formulario2_id', 'id');
    }
    //relacion reversa con rl_tipo
    public function tipo(){
        return $this->belongsTo(Tipo::class, 'tipo_id', 'id');
    }
    //relacion reversa con rl_categoria
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
    //relacion reversa con rl_bienservicio
    public function bien_servicio(){
        return $this->belongsTo(BienNServicio::class, 'bnservicio_id', 'id');
    }
    //relacion de muchos a muchos con rl_unidad_carrera
    public function unidad_responsable(){
        return $this->belongsToMany(UnidadCarreraArea::class, 'formulario4_unidad_res', 'formulario4_id', 'unidad_id');
    }
    //relacion con formulario 5
    public function formulario5_f4(){
        return $this->hasMany(Formulario5::class, 'formulario4_id', 'id');
    }
    //relacion con rl_asignacion_monto_form4
    public function asignacion_monto_f4(){
        return $this->hasMany(Asignacion_montof4::class, 'formulario4_id', 'id');
    }
}
