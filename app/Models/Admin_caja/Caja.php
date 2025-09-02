<?php

namespace App\Models\Admin_caja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin_caja\Historial_caja;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion\Financiamiento_tipo;

class Caja extends Model
{
    use HasFactory;
    protected $table = 'rl_caja';
    protected $fillable=[
        'saldo',
        'fecha',
        'gestiones_id',
        'documento_privado',
        'unidad_carrera_id',
        'financiamiento_tipo_id',
        'usuario_id',
    ];
    public $timestamps = false;
    //relacion con historial caja
    public function historial_caja(){
        return $this->hasMany(Historial_caja::class, 'caja_id', 'id');
    }
    //relacion reversa con rl_unidada_carrera
    public function reversa_unidadCarrera(){
        return $this->belongsTo(UnidadCarreraArea::class, 'unidad_carrera_id', 'id');
    }
    //relacion reversa con rl_financiamiento_tipo
    public function financiamiento_tipo(){
        return $this->belongsTo(Financiamiento_tipo::class, 'financiamiento_tipo_id', 'id');
    }
}
