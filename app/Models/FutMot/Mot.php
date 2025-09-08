<?php
namespace App\Models\FutMot;

use App\Models\Areas_estrategicas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mot extends Model
{
    use HasFactory;

    protected $table      = 'mot';
    protected $primaryKey = 'id_mot';
    protected $fillable   = [
        'id_configuracion_formulado',
        'nro',
        'area_estrategica_de',
        'ae_de_importe',
        'area_estrategica_a',
        'ae_a_importe',
        'objetivo_gestion_de',
        'og_de_importe',
        'objetivo_gestion_a',
        'og_a_importe',
        'tarea_proyecto_de',
        'tp_de_importe',
        'tarea_proyecto_a',
        'tp_a_importe',
        'respaldo_tramite',
        'fecha_tramite',
        'unidad_solicitante',
    ];
    public function ae_de()
    {
        return $this->belongsTo(Areas_estrategicas::class, 'area_estrategica_de', 'id');
    }
    public function ae_a()
    {
        return $this->belongsTo(Areas_estrategicas::class, 'area_estrategica_a', 'id');
    }
    public function total()
    {
        return $this->hasManyThrough(MotMov::class, MotPP::class, 'id_mot', 'id_mot_pp', 'id_mot');
    }
}
