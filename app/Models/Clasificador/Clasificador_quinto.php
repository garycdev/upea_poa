<?php
namespace App\Models\Clasificador;

use App\Models\Clasificador\Detalle_quintoClasificador;
use App\Models\Poa\Medida_bienservicio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificador_quinto extends Model
{
    use HasFactory;
    protected $table    = 'rl_clasificador_quinto';
    protected $fillable = [
        'codigo',
        'titulo',
        'descripcion',
        'id_clasificador_cuarto',
        'modificacion'
    ];
    public $timestamps = false;

    //relacion de uno a muchos con rl_detalleclasiquinto
    public function detalle_quinto_clasificador()
    {
        return $this->hasMany(Detalle_quintoClasificador::class, 'quintoclasificador_id', 'id');
    }

    public function medida_bienservicio()
    {
        return $this->hasMany(Medida_bienservicio::class, 'formulario5_id', 'id');
    }
}
