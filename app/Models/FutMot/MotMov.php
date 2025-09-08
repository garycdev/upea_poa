<?php
namespace App\Models\FutMot;

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
}
