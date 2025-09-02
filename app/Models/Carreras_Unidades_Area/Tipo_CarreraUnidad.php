<?php

namespace App\Models\Carreras_Unidades_Area;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Configuracion\UnidadCarreraArea;
class Tipo_CarreraUnidad extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_carrera';
    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;
    //relacion de muchos a muchos en laravel
    public function carrera_unidad_area(){
        return $this->hasMany(UnidadCarreraArea::class, 'id_tipo_carrera', 'id');
    }
    //para comnvertir en mayusculas
    protected function nombre():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => $value
        );
    }
}
