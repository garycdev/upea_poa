<?php
namespace App\Models\FutMot;

use App\Models\Configuracion\Financiamiento_tipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotPP extends Model
{
    use HasFactory;
    protected $table      = 'mot_partidas_presupuestarias';
    protected $primaryKey = 'id_mot_pp';
    protected $fillable   = [
        'organismo_financiador',
        'accion',
        'id_mot',
    ];
    public $timestamps = false;

    public function partidas_presupuestarias()
    {
        return $this->belongsTo(MotPP::class, 'id_mot', 'id_mot');
    }
    public function of()
    {
        return $this->belongsTo(Financiamiento_tipo::class, 'organismo_financiador', 'id');
    }
    public function mov()
    {
        return $this->hasMany(MotMov::class, 'id_mot_pp', 'id_mot_pp');
    }
}
