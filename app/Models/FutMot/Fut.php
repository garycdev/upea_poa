<?php
namespace App\Models\FutMot;

use App\Models\Areas_estrategicas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fut extends Model
{
    use HasFactory;

    protected $table      = 'fut';
    protected $primaryKey = 'id_fut';
    protected $fillable   = [
        'id_configuracion_formulado',
        'nro',
        'area_estrategica',
        'objetivo_gestion',
        'tarea_proyecto',
        'respaldo_tramite',
        'fecha_tramite',
        'unidad_solicitante',
        'nro_preventivo',
    ];
    public function ae()
    {
        return $this->belongsTo(Areas_estrategicas::class, 'area_estrategica', 'id');
    }
    public function total()
    {
        return $this->hasManyThrough(
            FutMov::class,
            FutPP::class, 'id_fut', 'id_fut_pp', 'id_fut');
    }
}
