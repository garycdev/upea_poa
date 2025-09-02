<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_cuarto;

class Detalle_cuartoClasificador extends Model
{
    use HasFactory;
    protected $table = 'rl_detalleClasiCuarto';
    protected $fillable=[
        'titulo',
        'estado',
        'descripcion',
        'cuartoclasificador_id'
    ];
    public $timestamps = false;
    //relacion reversa con clasificador cuarto
    public function clasificador_cuarto(){
        return $this->belongsTo(Clasificador_cuarto::class, 'cuartoclasificador_id', 'id');
    }
}
