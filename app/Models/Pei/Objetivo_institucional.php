<?php

namespace App\Models\Pei;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pei\Objetivo_estrategico_sub;
use App\Models\Pei\Matriz_planificacion;

class Objetivo_institucional extends Model
{
    use HasFactory;
    protected $table = "rl_objetivo_institucional";
    protected $primaryKey = "id";
    protected $fillable=[
        "codigo",
        "descripcion",
        'id_objetivo_estrategico_sub'
    ];

    public $timestamps = false;

    /**
     * reversa relacion : Objetivo estrategico cub
     */
    public function reversa_objetivo_estrategico_sub(){
        return $this->belongsTo(Objetivo_estrategico_sub::class, 'id_objetivo_estrategico_sub', 'id');
    }

    //relacion con MATRIZ DE PLANIFICACIÓN
    /* public function matriz_plan_obj_institucional_pei(){
        return $this->hasMany(Matriz_planificacion::class, 'id_obj_institucional', 'id');
    } */
}
