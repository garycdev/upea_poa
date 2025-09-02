<?php

namespace App\Models\Pei;

use App\Models\Pdu\Politica_desarrollo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Pei\Objetivo_institucional;
use App\Models\Pei\Matriz_planificacion;


class Objetivo_estrategico_sub extends Model
{
    use HasFactory;
    protected $table = "rl_objetivo_estrategico_sub";
    protected $primaryKey = "id";
    protected $fillable=[
        "codigo",
        "descripcion",
        'id_politica_desarrollo'
    ];

    public $timestamps = false;

    /**
     * relacion con objetivo institucional
     * tabla : objetivo institucional
     */
    public function relacion_objetivo_institucional(){
        return $this->hasMany(Objetivo_institucional::class, 'id_objetivo_estrategico_sub', 'id')->orderBy('codigo', 'asc');
    }

    /**
     * relacion reversa con politica de dearrollo
     */
    public function reversa_politica_desarrollo(){
        return $this->belongsTo(Politica_desarrollo::class, 'id_politica_desarrollo', 'id');
    }
    /**relacion con la matriz de planificacion */
    public function relacion_matriz_planificacion(){
        return $this->belongsToMany(Matriz_planificacion::class, 'matriz_objetivo_estrategico_sub', 'matriz_id', 'obj_estrategico_sub_id');
    }
}
