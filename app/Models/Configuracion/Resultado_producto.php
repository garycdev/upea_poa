<?php

namespace App\Models\Configuracion;

use App\Models\Pei\Matriz_planificacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado_producto extends Model
{
    use HasFactory;
    protected $table = 'rl_resultado_producto';
    protected $primaryKey = 'id';

    protected $fillable=[
        'codigo',
        'descripcion',
    ];
    public $timestamps = false;
    //relacion con matriz de planificacion
    public function matriz_resultado_producto(){
        return $this->hasMany(Matriz_planificacion::class, 'id_resultado_producto', 'id');
    }
}
