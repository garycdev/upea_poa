<?php

namespace App\Models\Pei;

use App\Models\Gestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Pei\Matriz_planificacion;
use App\Models\Poa\Formulario2;

class Indicador extends Model
{
    use HasFactory;
    protected $table = 'rl_indicador';

    protected $fillable=[
        'codigo',
        'descripcion',
        'estado',
        'id_gestion'
    ];

    public $timestamps = false;

    //relacion reversa de idnciador a gestion
    public function reversa_gestion_indicador(){
        return $this->BelongsTo(Gestion::class, 'id_gestion', 'id');
    }

    //relacion de uno a uno con la matriz de planificacion
    public function matriz_planificacion_in(){
        return $this->hasOne(Matriz_planificacion::class, 'id_indicador', 'id');
    }

    //relacion de indicador
    public function relacion_formulario2(){
        return $this->hasMany(Formulario2::class,'indicador_id', 'id');
    }
}
