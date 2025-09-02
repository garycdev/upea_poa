<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_primero;
use App\Models\Clasificador\Clasificador_tercero;

class Clasificador_segundo extends Model
{
    use HasFactory;
    protected $table = 'rl_clasificador_segundo';
    protected $fillable=[
        'codigo',
        'titulo',
        'descripcion',
        'id_clasificador_primero',
    ];
    public $timestamps = false;
    //relacion con rl_clasificador_tercero
    public function clasificador_tercero(){
        return $this->hasMany(Clasificador_tercero::class, 'id_clasificador_segundo', 'id');
    }

    //relacion reversa con rl_clasificador_primero
    public function clasificador_primero(){
        return $this->belongsTo(Clasificador_primero::class, 'id_clasificador_primero', 'id');
    }
}
