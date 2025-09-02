<?php

namespace App\Models\Poa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poa\Formulario4;

class BienNServicio extends Model
{
    use HasFactory;
    protected $table = 'rl_bienservicio';
    protected $fillable=[
        'nombre',
    ];
    public $timestamps = false;

    //relacion de uno a muchos con rl_bienservicio
    public function formulario4(){
        return $this->hasMany(Formulario4::class, 'bnservicio_id', 'id');
    }
}
