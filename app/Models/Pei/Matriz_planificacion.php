<?php

namespace App\Models\Pei;

use App\Models\Areas_estrategicas;
use App\Models\Configuracion\Categoria;
use App\Models\Configuracion\Programa_proyecto_accion_e;
use App\Models\Configuracion\Resultado_producto;
use App\Models\Configuracion\Tipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Pdu\Objetivo_estrategico;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Objetivo_institucional;
use App\Models\Pei\Objetivo_estrategico_sub;

class Matriz_planificacion extends Model
{
    use HasFactory;
    protected $table = 'rl_matriz_planificacion';

    protected $fillable=[
        'codigo',
        'id_pol_desarrollo_pdu',
        'id_obj_estrategico_pdu',
        'id_pol_institucional_pei',
        'id_obj_sub',
        'id_obj_institucional',
        'id_indicador',
        'id_tipo',
        'id_categoria',
        'id_resultado_producto',
        'linea_base',
        'gestion_1',
        'gestion_2',
        'gestion_3',
        'gestion_4',
        'gestion_5',
        'meta_mediano_plazo',
        'id_programa_proy',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';


    //relacion de muchos a muchos con unidad administrativa
    public function unidades_administrativas_inv(){
        return $this->belongsToMany(UnidadCarreraArea::class, 'matriz_unidad_inv', 'matriz_id_inv', 'unidad_id_inv');
    }

    //relacion de muchos a muchos co n unidades administrativas
    public function unidades_administrativas_res(){
        return $this->belongsToMany(UnidadCarreraArea::class, 'matriz_unidad_res', 'matriz_id_res', 'unidad_id_res');
    }

    //relacion de muchos a muchos con objetivo estrategico
    public function objetivo_estrategico(){
        return $this->belongsToMany(Objetivo_estrategico::class, 'matriz_objetivo_estrategico', 'matriz_id', 'objetivo_estrategico_id');
    }
    //relacion de muchos a muchos con objetivo estrategico sub
    public function objetivo_estrategico_sub(){
        return $this->belongsToMany(Objetivo_estrategico_sub::class, 'matriz_objetivo_estrategico_sub', 'matriz_id', 'obj_estrategico_sub_id');
    }
    //relacion de muchos a muchoss con objetivo institucional
    public function objetivo_institucional(){
        return $this->belongsToMany(Objetivo_institucional::class, 'matriz_objetivo_institucional', 'matriz_id', 'obj_institucional_id');
    }
    //relacion de muchos a muchos con politica de desarrollo pei
    public function politica_desarrollo_pei(){
        return $this->belongsToMany(Politica_desarrollo::class, 'matriz_politica_desarrollo_pei', 'matriz_id', 'politica_desarrollo_pei');
    }

    //relacion de muchos a muchos con politica de desarrollo pei
    public function politica_desarrollo_pdu(){
        return $this->belongsToMany(Politica_desarrollo::class, 'matriz_politica_desarrollo_pdu', 'matriz_id', 'politica_desarrollo_pdu');
    }

    //relacion reversa con OBJETIVO ESTRATGICO PDU
    /* public function objetivo_estrategico_pdu(){
        return $this->belongsTo(Objetivo_estrategico::class, 'id_obj_estrategico_pdu', 'id');
    } */
    //relacion reversa con OBJETIVO INSTITUCIONAL PEI
    /* public function objetivo_institucional_pei(){
        return $this->belongsTo(Objetivo_institucional::class, 'id_obj_institucional', 'id');
    } */
    //relacion de uno a uno con INDICADOR
    public function indicador_pei(){
        return $this->belongsTo(Indicador::class, 'id_indicador', 'id');
    }
    //reversa relacion de  TIPO
    public function tipo(){
        return $this->belongsTo(Tipo::class, 'id_tipo', 'id');
    }
    //reversa relacion de  CATEGORIA
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id');
    }
    //reversa de relacion Resultado Producto
    public function resultado_producto(){
        return $this->belongsTo(Resultado_producto::class, 'id_resultado_producto', 'id');
    }
    //reversa de relacion programa proy acc est
    public function programa_proyecto_accion(){
        return $this->belongsTo(Programa_proyecto_accion_e::class, 'id_programa_proy', 'id');
    }

    //relacion con areas estrategicas reversa
    public function areas_estrategicas(){
        return $this->belongsTo(Areas_estrategicas::class, 'id_area_estrategica', 'id');
    }
}
