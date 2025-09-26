<?php
namespace App\Models\FutMot;

use App\Models\Areas_estrategicas;
use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Pei\Objetivo_institucional;
use App\Models\Poa\Operacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'importe',
        'respaldo_tramite',
        'fecha_tramite',
        'estado',
        'observacion',
        'id_unidad_carrera',
        'nro_preventivo',
    ];

    protected $casts = [
        'area_estrategica' => 'array',
        'objetivo_gestion' => 'array',
        'tarea_proyecto'   => 'array',
    ];

    // public function ae()
    // {
    //     return $this->belongsTo(Areas_estrategicas::class, 'area_estrategica', 'id');
    // }
    public function areas_estrategicas()
    {
        return Areas_estrategicas::whereIn('id', $this->area_estrategica)->get();
    }
    public function objetivos_gestion()
    {
        return Objetivo_institucional::whereIn('id', $this->objetivo_gestion)->get();
    }
    public function tareas_proyectos()
    {
        return Operacion::whereIn('id', $this->tarea_proyecto)->get();
    }
    public function futpp()
    {
        return $this->hasMany(FutPP::class, 'id_fut', 'id_fut');
    }
    public function unidad_carrera()
    {
        return $this->hasOne(UnidadCarreraArea::class, 'id', 'id_unidad_carrera');
    }

    public function fuentesFinanciamiento()
    {
        return $this->hasManyThrough(
            Financiamiento_tipo::class,
            FutPP::class,
            'id_fut',
            'id',
            'id',
            'organismo_financiador'
        );
    }

    public function total()
    {
        return $this->hasManyThrough(
            FutMov::class,
            FutPP::class, 'id_fut', 'id_fut_pp', 'id_fut');
    }

    public function getTotalPresupuestoAttribute()
    {
        return FutMov::query()
            ->select(DB::raw('SUM(mbs.total_presupuesto) as total'))
            ->join('fut_partidas_presupuestarias as pp', 'pp.id_fut_pp', '=', 'fut_movimiento.id_fut_pp')
            ->join('rl_medida_bienservicio as mbs', 'mbs.id', '=', 'fut_movimiento.id_mbs')
            ->where('pp.id_fut', $this->id_fut)
            ->value('total') ?? 0;
    }

    public function configuracion()
    {
        return $this->hasOne(Configuracion_formulado::class, 'id', 'id_configuracion_formulado');
    }
}
