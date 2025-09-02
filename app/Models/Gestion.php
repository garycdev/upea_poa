<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pdes\Pdes_articulacion;
use App\Models\Areas_estrategicas;
use App\Models\Pei\Indicador;
use App\Models\Gestiones;

class Gestion extends Model
{
    use HasFactory;
    protected $table = 'rl_gestion';
    protected $primaryKey = 'id';

    protected $fillable=[
        'inicio_gestion',
        'fin_gestion',
        'estado'
    ];

    public $timestamps = false;

    //relacion con articulacion PDES
    public function relacion_pdes(){
        return $this->hasOne(Pdes_articulacion::class, 'id_gestion', 'id');
    }
    //relacion con areas estrategicas
    public function relacion_areas_estrategicas(){
        return $this->hasMany(Areas_estrategicas::class, 'id_gestion', 'id')->orderBy('codigo_areas_estrategicas', 'asc');
    }
    //relacion con indicador
    public function relacion_indicador(){
        return $this->hasMany(Indicador::class, 'id_gestion', 'id')->orderBy('codigo','asc');
    }
    //relacion con las gestiones
    public function relacion_gestiones(){
        return $this->hasMany(Gestiones::class, 'id_gestion', 'id');
    }
}
