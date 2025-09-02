<?php

namespace App\Models\Pdu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Matriz_planificacion;

class Objetivo_estrategico extends Model
{
    use HasFactory;
    protected $table = "rl_objetivo_estrategico";
    protected $primaryKey = "id";
    protected $fillable=[
        'codigo',
        'descripcion',
        'id_politica_desarrollo'
    ];

    public $timestamps = false;

    //relacion inversa objetivo estrategico a politica de desarrollo
    public function relacion_inversa_objetivo_estrategico_pol_desarrollo(){
        return $this->belongsTo(Politica_desarrollo::class, 'id_politica_desarrollo', 'id');
    }

    //relacion con la matriz de planificacion
    /* public function matriz_planificacion_obj_est_pdu(){
        return $this->hasMany(Matriz_planificacion::class, 'id_obj_estrategico_pdu', 'id');
    } */
    //relacion de muchos a muchos con la matriz de planificacion
    public function obj_estrategico_matriz_planificacion(){
        return $this->belongsToMany(Matriz_planificacion::class, 'matriz_objetivo_estrategico', 'matriz_id', 'objetivo_estrategico_id');
    }
}
