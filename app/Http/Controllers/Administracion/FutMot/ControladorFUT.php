<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestiones;
use Illuminate\Support\Facades\Auth;

class ControladorFUT extends Controller
{
    public function inicio()
    {
        // Vista inicio (Validar seguimiento solo admins y tecnicos)
        $data['menu'] = 19;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['unidades']       = UnidadCarreraArea::get();
            $data['gestiones']      = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->orderBy('gestion', 'ASC')
                ->get();

            return view('administrador.fut.inicio', $data);
        } else {
            $data['unidades']  = UnidadCarreraArea::get();
            $data['gestiones'] = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->orderBy('gestion', 'ASC')
                ->get();

            return view('administrador.fut.inicio', $data);
        }
    }
}
