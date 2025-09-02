<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_tercero;
use App\Models\Clasificador\Clasificador_quinto;
use App\Models\Clasificador\Detalle_cuartoClasificador;

class Clasificador_cuarto extends Model
{
    use HasFactory;
    protected $table = 'rl_clasificador_cuarto';
    protected $fillable=[
        'codigo',
        'titulo',
        'descripcion',
        'id_clasificador_tercero',
    ];
    public $timestamps = false;
    //relacion con clasificador quinto
    public function clasificador_quinto(){
        return $this->hasMany(Clasificador_quinto::class, 'id_clasificador_cuarto', 'id');
    }

    //relacion reversa con clasificador tercero
    public function clasificador_tercero(){
        return $this->belongsTo(Clasificador_tercero::class, 'id_clasificador_tercero', 'id');
    }

    //relacion de muchos a muchos con rl_detalleclasicuarto
    public function detalle_cuarto_clasificador(){
        return $this->hasMany(Detalle_cuartoClasificador::class, 'cuartoclasificador_id', 'id');
    }
}
