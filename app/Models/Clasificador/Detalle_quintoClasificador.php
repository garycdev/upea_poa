<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clasificador\Clasificador_quinto;

class Detalle_quintoClasificador extends Model{
    use HasFactory;
    protected $table = 'rl_detalleClasiQuinto';
    protected $fillable=[
        'titulo',
        'estado',
        'descripcion',
        'quintoclasificador_id'
    ];
    public $timestamps = false;

    //relacion reversa de el rl_clasificador_quinto
    public function clasificador_quinto(){
        return $this->belongsTo(Clasificador_quinto::class, 'quintoclasificador_id', 'id');
    }
}
