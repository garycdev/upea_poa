<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Operacion;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tipo_operacion extends Model
{
    use HasFactory;
    protected $table = 'rl_tipo_operacion';
    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;
    protected function nombre():Attribute{
        return new Attribute(
            get: fn ($value) => mb_strtoupper($value)
        );
    }

    //relacion con rl_operacion
    public function Operacion(){
        return $this->hasMany(Operacion::class, 'tipo_operacion_id', 'id');
    }
}
