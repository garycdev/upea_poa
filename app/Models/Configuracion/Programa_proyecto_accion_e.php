<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa_proyecto_accion_e extends Model
{
    use HasFactory;
    protected $table = 'rl_programa_proy_acc_est';
    protected $primaryKey = 'id';

    protected $fillable=[
        'id_tipo_prog_acc',
        'descripcion',
    ];
    public $timestamps = false;
    //relacion con la matriz de planificacion
    public function relacion_matriz_prog(){
        return $this->hasMany(Matriz_planificacion::class, 'id_programa_proy', 'id');
    }
}
