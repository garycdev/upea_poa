<?php

namespace App\Models\Poa;

use App\Models\Clasificador\Detalle_cuartoClasificador;
use App\Models\Clasificador\Detalle_quintoClasificador;
use App\Models\Clasificador\Detalle_tercerClasificador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Medida;
use App\Models\Poa\Formulario5;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Configuracion\Financiamiento_tipo;

class Medida_bienservicio extends Model
{
    use HasFactory;
    protected $table = 'rl_medida_bienservicio';
    protected $fillable=[
        'formulario5_id',
        'medida_id',
        'cantidad',
        'precio_unitario',
        'total_presupuesto',
        'tipo_financiamiento_id',
        'fecha_requerida',
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';
    //relacion reversa rl_medida
    public function medida(){
        return $this->belongsTo(Medida::class, 'medida_id', 'id');
    }
    //relacion reversa de rl_formulario5
    public function formulario5(){
        return $this->belongsTo(Formulario5::class, 'formulario5_id', 'id');
    }

    //relacion de muchos a muchos con detalles del tercer clasificador
    public function detalle_tercer_clasificador(){
        return $this->belongsToMany(Detalle_tercerClasificador::class, 'detalleTercerClasi_medida_bn', 'medidabn_id', 'detalle_tercerclasif_id');
    }

    //relacion de muchos a muchos con el cuarto clasificador
    public function detalle_cuarto_clasificador(){
        return $this->belongsToMany(Detalle_cuartoClasificador::class, 'detalleCuartoClasi_medida_bn', 'medidabn_id', 'detalle_cuartoclasif_id');
    }

    //relacion de muchos a muchos con el quinto clasificador
    public function detalle_quinto_clasificador(){
        return $this->belongsToMany(Detalle_quintoClasificador::class, 'detalleQuintoClasi_medida_bn', 'medidabn_id', 'detalle_quintoclasif_id');
    }

    public function tipo_financiamiento(){
        return $this->belongsTo(Financiamiento_tipo::class, 'tipo_financiamiento_id', 'id');
    }
}
