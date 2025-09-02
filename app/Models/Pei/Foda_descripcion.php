<?php

namespace App\Models\Pei;

use App\Models\Areas_estrategicas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pei\Tipo_foda;
use App\Models\Pei\Tipo_plan;
class Foda_descripcion extends Model
{
    use HasFactory;
    protected $table = 'rl_foda_descripcion';

    protected $fillable=[
        'descripcion',
        'id_area_estrategica',
        'id_tipo_foda',
        'id_tipo_plan'
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';


    //relacion reversa de foda_descripcion con tipo de foda
    public function reversa_relacion_tipo_foda_foda_descripcion(){
        return $this->belongsTo(Tipo_foda::class, 'id_tipo_foda', 'id');
    }

    //relacion reversa de foda_descripcion con tipo de plan
    public function reversa_relacion_tipo_plan_foda_descripcion(){
        return $this->belongsTo(Tipo_plan::class, 'id_tipo_plan', 'id');
    }

    //relacion reversa de relacion_foda_descripcion
    public function reversa_relacion_foda_descripcion(){
        return $this->belongsTo(Areas_estrategicas::class,'id_area_estrategica','id');
    }
}
