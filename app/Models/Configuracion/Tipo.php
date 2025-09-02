<?php

namespace App\Models\Configuracion;

use App\Models\Pei\Matriz_planificacion;
use App\Models\Poa\Formulario4;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo';
    protected $primaryKey = 'id';

    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;

    //relacion de uno a muchos con matriz de planificacion
    public function matriz_tipo(){
        return $this->hasMany(Matriz_planificacion::class, 'id_tipo', 'id');
    }

    //relacion de uno a muchos con rl_formuladio4
    public function rel_formulario4(){
        return $this->hasMany(Formulario4::class, 'tipo_id', 'id');
    }
}
