<?php

namespace App\Models\Clasificador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Clasificador\Clasificador_primero;

class Clasificador_tipo extends Model
{
    use HasFactory;
    protected $table = 'rl_clasificador_tipo';
    protected $fillable=[
        'titulo',
        'descripcion',
        'estado',
    ];
    public $timestamps = false;
    protected function titulo():Attribute{
        return new Attribute(
            set: fn ($value) => mb_strtoupper($value),
            get: fn ($value) => mb_strtoupper($value),
        );
    }

    //relaciones de uno a muchos con rl_clasificador_primero
    public function clasificador_primero(){
        return $this->hasMany(Clasificador_primero::class, 'id_clasificador_tipo', 'id')->orderBy('codigo', 'asc');
    }
}
