<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Gestiones;
use App\Models\Poa\Formulario1;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControladorPrincipal extends Controller
{
    public function index(Request $request)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', '=', Auth::user()->id)
            ->first();
        $unidad_carrera = DB::table('rl_unidad_carrera')
            ->where('estado', '=', 'activo')
            ->get();
        $usuarios = null;
        $forms    = DB::table('rl_formulado_tipo')->where('estado', '=', 'activo')->get();
        if ($rol->role_id == 4) {
            $formulados = Formulario1::where('unidadCarrera_id', '=', Auth::user()->id_unidad_carrera)
                ->orderBy('gestion_id', 'DESC')
                ->get();

            $mots = DB::table('mot')->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)->get();
            $futs = DB::table('fut')->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)->get();

            $gestiones = Gestiones::where('estado', '=', 'activo')
                ->orderBy('id', 'DESC')
                ->get();

            $usuarios = User::where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
                ->where('estado', '=', 'activo')
                ->get();
        } else {
            $formulados = Formulario1::orderBy('gestion_id', 'DESC')
                ->get();

            $mots = DB::table('mot')->get();
            $futs = DB::table('fut')->get();

            $gestiones = Gestiones::where('estado', '=', 'activo')
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('home', compact('unidad_carrera', 'forms', 'formulados', 'mots', 'futs', 'gestiones', 'usuarios'));
    }

    public function getRole()
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', '=', Auth::user()->id)
            ->first();
        return $rol;
    }
}
