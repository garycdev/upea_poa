<?php

namespace App\Models\Poa;

use App\Models\Gestiones;
use App\Models\Pei\Tipo_foda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foda_carrerasUnidad extends Model
{
    use HasFactory;
    protected $table = 'rl_foda_carreras_unidad';
    protected $fillable=[
        'descripcion',
        'estado',
        'tipo_foda_id',
        'gestion_id',
        'UnidadCarrera_id',
        'usuario_id'
    ];
    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    //relacion reversa de rl_tipo_foda
    public function tipo_foda(){
        return $this->belongsTo(Tipo_foda::class, 'tipo_foda_id', 'id');
    }
    //relacion reversa de rl_gestiones
    public function gestiones(){
        return $this->belongsTo(Gestiones::class, 'gestion_id', 'id');
    }
}
