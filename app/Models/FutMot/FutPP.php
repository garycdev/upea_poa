<?php

namespace App\Models\FutMot;

use App\Models\Configuracion\Financiamiento_tipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutPP extends Model
{
    use HasFactory;
    protected $table = 'fut_partidas_presupuestarias';
    protected $primaryKey = 'id_fut_pp';
    protected $fillable = [
        'organismo_financiador',
        'categoria_progmatica',
        'id_fut',
    ];
    public $timestamps = false;

    public function partidas_presupuestarias()
    {
        return $this->belongsTo(FutPP::class, 'id_fut', 'id_fut');
    }
    public function of()
    {
        return $this->belongsTo(Financiamiento_tipo::class, 'organismo_financiador', 'id');
    }
    public function mov(){
        return $this->hasMany(FutMov::class, 'id_fut_pp', 'id_fut_pp');
    }
}
