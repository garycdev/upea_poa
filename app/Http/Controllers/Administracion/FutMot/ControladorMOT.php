<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Clasificador\Clasificador_cuarto;
use App\Models\Clasificador\Clasificador_quinto;
use App\Models\Clasificador\Clasificador_tercero;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Gestiones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorMOT extends Controller
{
    // Vista inicio (Validar seguimiento solo admins y tecnicos)
    public function inicio()
    {
        $data['menu'] = 20;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['unidades']       = UnidadCarreraArea::get();
            $data['gestiones']      = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->get();

            return view('administrador.mot.inicio', $data);
        } else {
            $data['unidades']  = UnidadCarreraArea::get();
            $data['gestiones'] = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->get();

            return view('administrador.mot.inicio', $data);
        }
    }

    // Vista para inhabilitar partidas (rl_clasificador_tercero, rl_clasificador_cuarto y rl_clasificador_quinto)
    public function partidasHabilitadas()
    {
        $partidas3            = Clasificador_tercero::where('modificacion', false)->where('codigo', 'not like', '1%')->get();
        $partidas31           = Clasificador_tercero::where('modificacion', false)->get();
        $partidasHabilitadas3 = Clasificador_tercero::where('modificacion', true)->get();

        $partidas4            = Clasificador_cuarto::where('modificacion', false)->where('codigo', 'not like', '1%')->get();
        $partidas41           = Clasificador_cuarto::where('modificacion', false)->get();
        $partidasHabilitadas4 = Clasificador_cuarto::where('modificacion', true)->get();

        $partidas5            = Clasificador_quinto::where('modificacion', false)->where('codigo', 'not like', '1%')->get();
        $partidas51           = Clasificador_quinto::where('modificacion', false)->get();
        $partidasHabilitadas5 = Clasificador_quinto::where('modificacion', true)->get();

        $data['menu']                 = 23;
        $data['partidas3']            = $partidas3;
        $data['partidas31']           = $partidas31;
        $data['partidasHabilitadas3'] = $partidasHabilitadas3;
        $data['partidas4']            = $partidas4;
        $data['partidas41']           = $partidas41;
        $data['partidasHabilitadas4'] = $partidasHabilitadas4;
        $data['partidas5']            = $partidas5;
        $data['partidas51']           = $partidas51;
        $data['partidasHabilitadas5'] = $partidasHabilitadas5;

        return view('administrador.mot.partidas', $data);
    }

    // PUT inhabilitar partida
    public function inhabilitarPartida(Request $req)
    {
        // dd($req);
        $grupo = $req->grupo;

        switch ($grupo) {
            case 3:
                Clasificador_tercero::where('id', $req->id_partida)
                    ->update(['modificacion' => false]);
                break;
            case 4:
                Clasificador_cuarto::where('id', $req->id_partida)
                    ->update(['modificacion' => false]);
                break;
            case 5:
                Clasificador_quinto::where('id', $req->id_partida)
                    ->update(['modificacion' => false]);
                break;
            default:
                break;
        }

        session()->flash('mensaje', 'Partida inhabilitada correctamente');
        return redirect()->back();
    }

    // PUT habilitar partida
    public function habilitarPartida(Request $req)
    {
        $grupo = $req->grupo;

        switch ($grupo) {
            case 3:
                Clasificador_tercero::where('id', $req->id)
                    ->update(['modificacion' => true]);
                break;
            case 4:
                Clasificador_cuarto::where('id', $req->id_partida)
                    ->update(['modificacion' => true]);
                break;
            case 5:
                Clasificador_quinto::where('id', $req->id_partida)
                    ->update(['modificacion' => true]);
                break;
            default:
                break;
        }

        session()->flash('mensaje', 'Partida habilitada correctamente');
        return response()->json([
            'success' => true,
        ], 200);
    }

    // Obtener formulados por gestiones
    public function getFormulados(Request $req)
    {
        $id_gestion        = $req->input('id_gestion');
        $id_unidad_carrera = $req->input('id_unidad_carrera');

        $formulados = Configuracion_formulado::join('rl_formulado_tipo as rft', 'rl_configuracion_formulado.formulado_id', '=', 'rft.id')
            ->join('rl_formulario1 as f1', 'f1.configFormulado_id', '=', 'rl_configuracion_formulado.id')
            ->select('rl_configuracion_formulado.*', 'rft.descripcion')
            ->where('gestiones_id', '=', $id_gestion)
            ->where('f1.unidadCarrera_id', '=', $id_unidad_carrera)
            ->orderBy('formulado_id', 'asc')
            ->get();

        $formulados->transform(function ($item) {
            $item->id_encriptado = encriptar($item->id);
            return $item;
        });

        return $formulados;
    }
}
