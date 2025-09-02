<?php

namespace App\Models\Pdu;

use App\Models\Areas_estrategicas;
use App\Models\Pei\Tipo_plan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pdu\Objetivo_estrategico;
use App\Models\Pei\Objetivo_estrategico_sub;

class Politica_desarrollo extends Model
{
    use HasFactory;

    protected $table = "rl_politica_de_desarrollo";
    protected $primaryKey = "id";
    protected $fillable = [
        'codigo',
        'descripcion',
        'id_area_estrategica',
        'id_tipo_plan',
    ];
    public $timestamps = false;

    //relacion con objetivo estrategico
    public function relacion_objetivo_estrategico(){
        return $this->hasMany(Objetivo_estrategico::class,'id_politica_desarrollo', 'id')->orderBy('codigo','asc');
    }

    //relacion reversa de politica de desarrrollo con tipo plan
    public function relacion_inversa_politica_desarrollo_tipo_plan(){
        return $this->belongsTo(Tipo_plan::class, 'id_tipo_plan', 'id');
    }

    //relacion reversa de areas estrategicas
    public function relacion_inversa_areas_estrategicas(){
        return $this->belongsTo(Areas_estrategicas::class, 'id_area_estrategica', 'id');
    }

    //relacion PDI: politica de desarrollo con objetivo estrategico CUB
    public function relacion_objetivo_estrategico_sub(){
        return $this->hasMany(Objetivo_estrategico_sub::class, 'id_politica_desarrollo', 'id')->orderBy('codigo', 'asc');
    }
}
