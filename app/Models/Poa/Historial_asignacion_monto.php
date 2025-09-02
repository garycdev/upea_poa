<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Asignacion_montof4;

class Historial_asignacion_monto extends Model
{
    use HasFactory;
    protected $table = 'rl_historial_asignacion_monto';
    protected $fillable=[
        'asignacionMontof4_id',
        'monto',
        'fecha',
    ];
    public $timestamps = false;
    //relacion reversa
    public function asignacion_montof4(){
        return $this->belongsTo(Asignacion_montof4::class, 'asignacionMontof4_id', 'id');
    }
}
