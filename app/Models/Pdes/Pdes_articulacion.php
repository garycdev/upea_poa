<?php

namespace App\Models\Pdes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Gestion;

class Pdes_articulacion extends Model
{
    use HasFactory;
    protected $table = 'rl_articulacion_pdes';
    protected $primaryKey = 'id';

    protected $fillable=[
        'codigo_eje',
        'descripcion_eje',
        'codigo_meta',
        'descripcion_meta',
        'codigo_resultado',
        'descripcion_resultado',
        'codigo_accion',
        'descripcion_accion',
        'id_gestion',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';


    //par guardar en mayuscula las descipciones
    protected function descripcioneje():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => $value
        );
    }
    protected function descripcionmeta():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => $value
        );
    }

    protected function descripcionresultado():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => $value
        );
    }

    protected function descripcionaccion():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => ucfirst(mb_strtolower($value)),
        );
    }



    //reversa de relación con gestion
    public function reversa_articulacion_pdes_gestion(){
        return $this->belongsTo(Gestion::class, 'id_gestion', 'id');
    }
}
