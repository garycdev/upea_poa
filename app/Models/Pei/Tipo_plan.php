<?php

namespace App\Models\Pei;

use App\Models\Pdu\Politica_desarrollo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_plan extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_plan';

    protected $fillable=[
        'nombre'
    ];

    public $timestamps = false;

    //relacion co foda descripcion
    public function relacion_tipo_plan_foda_descripcion(){
        return $this->hasMany(Foda_descripcion::class, 'id_tipo_plan', 'id');
    }

    //relacion con politica de desarrollo
    public function relacion_politica_desarrollo(){
        return $this->hasmany(Politica_desarrollo::class, 'id_tipo_plan', 'id');
    }
}
