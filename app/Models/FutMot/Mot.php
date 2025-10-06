<?php
namespace App\Models\FutMot;

use App\Models\Areas_estrategicas;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Pei\Objetivo_institucional;
use App\Models\Poa\Operacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'id_unidad_verifica',
        'id_unidad_aprueba',
    ];

    protected $casts = [
        'area_estrategica_de' => 'array',
        'area_estrategica_a'  => 'array',
        'objetivo_gestion_de' => 'array',
        'objetivo_gestion_a'  => 'array',
        'tarea_proyecto_de'   => 'array',
        'tarea_proyecto_a'    => 'array',
    ];

    public function configuracion()
    {
        return $this->hasOne(Configuracion_formulado::class, 'id', 'id_configuracion_formulado');
    }
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
    public function areas_estrategicas_de()
    {
        return Areas_estrategicas::whereIn('id', $this->area_estrategica_de)->get();
    }
    public function objetivos_gestion_de()
    {
        return Objetivo_institucional::whereIn('id', $this->objetivo_gestion_de)->get();
    }
    public function tareas_proyectos_de()
    {
        return Operacion::whereIn('id', $this->tarea_proyecto_de)->get();
    }
    public function areas_estrategicas_a()
    {
        return Areas_estrategicas::whereIn('id', $this->area_estrategica_a)->get();
    }
    public function objetivos_gestion_a()
    {
        return Objetivo_institucional::whereIn('id', $this->objetivo_gestion_a)->get();
    }

    public function motpp()
    {
        return $this->hasMany(MotPP::class, 'id_mot', 'id_mot');
    }

    public function mot_a()
    {
        return MotPP::query()
            ->select('*')
            ->where('mot_partidas_presupuestarias.accion', 'A')
            ->where('mot_partidas_presupuestarias.id_mot', $this->id_mot)
            ->first();
    }

    public function unidad_carrera()
    {
        return $this->hasOne(UnidadCarreraArea::class, 'id', 'id_unidad_carrera');
    }
    public function unidad_verifica()
    {
        return $this->hasOne(User::class, 'id', 'id_unidad_verifica');
    }
    public function unidad_aprueba()
    {
        return $this->hasOne(User::class, 'id', 'id_unidad_aprueba');
    }

    public function getTotalPresupuestoAttribute()
    {
        return MotMov::query()
            ->select(DB::raw('SUM(mbs.total_presupuesto) as total'))
            ->join('mot_partidas_presupuestarias as pp', 'pp.id_mot_pp', '=', 'mot_movimiento.id_mot_pp')
            ->join('rl_medida_bienservicio as mbs', 'mbs.id', '=', 'mot_movimiento.id_mbs')
            ->where('pp.id_mot', $this->id_mot)
            ->where('mbs.descripcion', null)
            ->value('total') ?? 0;
    }
}
