<?php

namespace App\Models\Configuracion;

use App\Models\Pei\Matriz_planificacion;
use App\Models\Poa\Formulario4;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'rl_categoria';
    protected $primaryKey = 'id';

    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;

    //relacion con matriz de planificacion
    public function matriz_categoria(){
        return $this->hasMany(Matriz_planificacion::class, 'id_categoria', 'id');
    }
    //relacion de uno a muchos con rl_formulario4
    public function formulario4(){
        return $this->hasMany(Formulario4::class, 'categoria_id', 'id');
    }
}
