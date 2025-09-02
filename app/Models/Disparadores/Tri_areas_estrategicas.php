<?php

namespace App\Models\Disparadores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tri_areas_estrategicas extends Model
{
    use HasFactory;
    protected $table = 'tri_areas_estrategicas';
    protected $primaryKey = 'id';

    protected $fillable=[
        'accion',
        'id_area_estrategica',
        'ant_codigo_area_estrategica',
        'ant_descripcion',
        'ant_estado',
        'ant_id_usuario',
        'ant_id_gestion',
        'nuevo_codigo_area_estrategica',
        'nuevo_descripcion',
        'nuevo_estado',
        'nuevo_id_usuario',
        'nuevo_id_gestion',
        'fecha',
    ];
    public $timestamps = false;
}
