<?php

namespace App\Models;

use App\Models\Configuracion_poa\Configuracion_formulado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gestion;
use App\Models\Poa\Foda_carrerasUnidad;

class Gestiones extends Model
{
    use HasFactory;
    protected $table = 'rl_gestiones';
    protected $primaryKey = 'id';

    protected $fillable=[
        'gestion',
        'estado',
        'id_gestion'
    ];

    public $timestamps = false;

    //relacioj inversa a gestion
    public function gestion(){
        return $this->belongsTo(Gestion::class, 'id_gestion', 'id');
    }
    //relacion con rl_configuracion_formulado
    public function configuracion_formulado(){
        return $this->hasMany(Configuracion_formulado::class, 'gestiones_id', 'id');
    }

    public function foda_carrerasUnidada(){
        return $this->hasMany(Foda_carrerasUnidad::class, 'gestion_id', 'id');
    }
}
