<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_tercero;

class Detalle_tercerClasificador extends Model
{
    use HasFactory;
    protected $table = 'rl_detalleClasiTercero';
    protected $fillable=[
        'titulo',
        'estado',
        'descripcion',
        'tercerclasificador_id'
    ];
    public $timestamps = false;

    //reversa de la relacion con clasificador tercero  **pertenece a...
    public function clasificador_tercero(){
        return $this->belongsTo(Clasificador_tercero::class, 'tercerclasificador_id', 'id');
    }
}
