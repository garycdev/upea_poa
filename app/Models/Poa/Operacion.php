<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Tipo_operacion;
use App\Models\Poa\Formulario5;

class Operacion extends Model
{
    use HasFactory;
    protected $table = 'rl_operaciones';
    protected $fillable=[
        'descripcion',
        'tipo_operacion_id',
        'area_estrategica_id',
    ];
    public $timestamps = false;
    //reversa de Tipo de operacion
    public function tipo_operacion(){
        return $this->belongsTo(Tipo_operacion::class, 'tipo_operacion_id', 'id');
    }
    //relacion con el formulario 5 de uno a muchos
    public function formulario5_op(){
        return $this->hasMany(Formulario5::class, 'operacion_id', 'id');
    }
}
