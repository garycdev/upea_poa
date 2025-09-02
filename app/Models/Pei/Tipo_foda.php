<?php

namespace App\Models\Pei;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pei\Foda_descripcion;
use App\Models\Poa\Foda_carrerasUnidad;

class Tipo_foda extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_foda';

    protected $fillable=[
        'nombre'
    ];

    public $timestamps = false;

    //relacion con Foda descripcion
    public function relacion_tipo_foda_foda_descripcion(){
        return $this->hasMany(Foda_descripcion::class, 'id_tipo_foda', 'id');
    }

    //relacion con rl_foda_carreras_unidad
    public function relacion_fodaCarrerasUnidad(){
        return $this->hasMany(Foda_carrerasUnidad::class, 'tipo_foda_id', 'id');
    }
}
