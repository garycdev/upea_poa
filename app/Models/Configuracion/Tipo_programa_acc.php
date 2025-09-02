<?php

namespace App\Models\Configuracion;

use App\Models\Pei\Matriz_planificacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_programa_acc extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_programa_acc';
    protected $primaryKey = 'id';

    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;
}
