<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Historial_asignacion_monto;
use App\Models\Configuracion\Financiamiento_tipo;

class Asignacion_montof4 extends Model
{
    use HasFactory;
    protected $table = 'rl_asignacion_monto_form4';
    protected $fillable=[
        'formulario4_id',
        'monto_asignado',
        'financiamiento_tipo_id',
        'fecha',
    ];
    public $timestamps = false;
    //relacion reversa
    public function formulario4(){
        return $this->belongsTo(Formulario4::class, 'formulario4_id', 'id');
    }
    //relacion con historial
    public function historial_asignacion_monto(){
        return $this->hasMany(Historial_asignacion_monto::class, 'asignacionMontof4_id', 'id');
    }
    //relacion reversa de financiamiento tipo
    public function financiamiento_tipo(){
        return $this->belongsTo(financiamiento_tipo::class, 'financiamiento_tipo_id', 'id');
    }
}
