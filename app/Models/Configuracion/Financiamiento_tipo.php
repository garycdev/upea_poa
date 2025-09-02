<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Admin_caja\Caja;
use App\Models\Poa\Asignacion_montof4;
use App\Models\Poa\Medida_bienservicio;

class Financiamiento_tipo extends Model
{
    use HasFactory;
    protected $table = 'rl_financiamiento_tipo';
    protected $fillable=[
        'sigla',
        'codigo',
        'descripcion',
        'estado',
    ];
    public $timestamps = false;

    protected function descripcion():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }
    //relacion con caja
    public function f_caja(){
        return $this->hasMany(Caja::class, 'financiamiento_tipo_id', 'id');
    }
    //relacion con rl_asignacion_monto_form4
    public function asignacion_monto_formulario4(){
        return $this->hasMany(Asignacion_montof4::class, 'financiamiento_tipo_id', 'id');
    }
    //relacion con rl_medida_bienservicio
    public function medida_bienservicio(){
        return $this->hasMany(Medida_bienservicio::class, 'tipo_financiamiento_id', 'id');
    }
}
