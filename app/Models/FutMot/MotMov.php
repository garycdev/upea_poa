<?php
namespace App\Models\FutMot;

use App\Models\Clasificador\Detalle_cuartoClasificador;
use App\Models\Clasificador\Detalle_quintoClasificador;
use App\Models\Clasificador\Detalle_tercerClasificador;
use App\Models\Poa\Medida_bienservicio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotMov extends Model
{
    use HasFactory;
    protected $table      = 'mot_movimiento';
    protected $primaryKey = 'id_mot_mov';
    protected $fillable   = [
        'id_detalle',
        'partida_codigo',
        'partida_monto',
        'id_mbs',
        'descripcion',
        'id_mot_pp',
    ];
    public $timestamps = false;

    public function movimiento()
    {
        return $this->belongsTo(MotMov::class, 'id_mot_pp', 'id_mot_pp');
    }
    public function mbs()
    {
        return $this->hasOne(Medida_bienservicio::class, 'id', 'id_mbs');
    }
    public function motpp()
    {
        return $this->hasOne(MotPP::class, 'id_mot_pp', 'id_mot_pp');
    }

    public function detalle()
    {
        $codigo = $this->partida_codigo;

        if (substr($codigo, -2) === "00") {
            return $this->hasOne(Detalle_tercerClasificador::class, 'id', 'id_detalle')->first();
        }

        if (substr($codigo, -1) === "0") {
            return $this->hasOne(Detalle_cuartoClasificador::class, 'id', 'id_detalle')->first();
        }

        return $this->hasOne(Detalle_quintoClasificador::class, 'id', 'id_detalle')->first();
    }
}
