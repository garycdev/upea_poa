<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Medida_bienservicio;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Medida extends Model
{
    use HasFactory;
    protected $table = 'rl_medida';
    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;
    protected function nombre():Attribute{
        return new Attribute(
            get: fn ($value) => mb_strtoupper($value)
        );
    }
    //relacion con rl_medida_bienservicio
    public function medida_bien_servicio(){
        return $this->hasMany(Medida_bienservicio::class, 'medida_id', 'id');
    }
}
