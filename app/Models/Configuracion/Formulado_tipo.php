<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion_poa\Configuracion_formulado;
class Formulado_tipo extends Model
{
    use HasFactory;
    protected $table = 'rl_formulado_tipo';
    protected $fillable=[
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

    //relacion con la tabla de rl_configuracion_formulado
    public function configuracion_formulado(){
        return $this->hasMany(Configuracion_formulado::class, 'formulado_id', 'id');
    }
}
