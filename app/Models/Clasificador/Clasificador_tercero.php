<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_segundo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Clasificador\Clasificador_cuarto;
use App\Models\Clasificador\Detalle_tercerClasificador;

class Clasificador_tercero extends Model
{
    use HasFactory;
    protected $table = 'rl_clasificador_tercero';
    protected $fillable=[
        'codigo',
        'titulo',
        'descripcion',
        'id_clasificador_segundo',
        'modificacion'
    ];
    public $timestamps = false;
    //relacion con clasificador cuarto
    public function clasificador_cuarto(){
        return $this->HasMany(Clasificador_cuarto::class, 'id_clasificador_tercero', 'id');
    }
    //relacion reversa con rl_clasificador_segundo
    public function clasificador_segundo(){
        return $this->belongsTo(Clasificador_segundo::class, 'id_clasificador_segundo', 'id');
    }
    //relacion con rl_detalleclasificador
    public function detalle_tercerclasificador(){
        return $this->hasMany(Detalle_tercerClasificador::class, 'tercerclasificador_id', 'id');
    }
}
