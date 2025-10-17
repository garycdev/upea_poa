<?php
namespace App\Http\Controllers;

use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestion;
use App\Models\Gestiones;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Formulario5;
use App\Models\Poa\Medida_bienservicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Usuario_controlador extends Controller
{

    //validar usuario
    public function validar_usuario(Request $req)
    {
        $req->validate([
            'usuario'  => 'required',
            'password' => 'required',
        ], [
            'usuario.required'  => 'El usuario es requerido',
            'password.required' => 'La contraseña es requerida',
        ]);

        $user = User::where('usuario', $req->usuario)->first();
        if (! $user) {
            session()->flash('error', 'El usuario no existe');
            return redirect()->back();
        }
        if (Auth::attempt(['usuario' => $req->usuario, 'password' => $req->password, 'estado' => 'activo', 'deleted_at' => null])) {
            $req->session()->regenerate();

            session()->flash('mensaje', 'Inicio de session con exito!');
            return redirect()->intended(route('inicio'));
        } else {
            session()->flash('error', 'Contraseña invalida!');
            return redirect()->back();
        }
    }

    // validar usuario por api (ya no se usa)
    public function validar_usuario_api(Request $request)
    {
        $mensaje = 'Usuario, contraseña o captcha invalidos';
        $valores = Validator::make($request->all(), [
            'usuario'  => 'required',
            'password' => 'required',
            'captcha'  => 'required',
        ]);
        if ($valores->fails()) {
            $data = [
                'tipo'    => 'validacion',
                'mensaje' => 'Todos los campos son requeridos',
            ];
        } else {
            //primero comprobamos capcha
            if ($request->captcha == session()->get('captchaText_recuperado')) {
                //comprobar si el usuario no ha sido eliminado o este inactivo
                $usuario = User::where('usuario', 'like', $request->usuario)->get();
                if ($usuario) {
                    if ($token = Auth::attempt(['usuario' => $request->usuario, 'password' => $request->password, 'estado' => 'activo', 'deleted_at' => null])) {
                        $request->session()->regenerate();

                        $data = [
                            'tipo'    => 'success',
                            'mensaje' => 'Inicio de session con exito!',
                        ];
                    } else {
                        $data = [
                            'tipo'    => 'error',
                            'mensaje' => $mensaje,
                        ];
                    }
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => $mensaje,
                    ];
                }
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => $mensaje,
                ];
            }

        }
        return response()->json($data, 200);
    }

    //para cerrar session
    public function cerrar_session(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }

    // cerrar sesion como api
    public function cerrar_session_api(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $data = [
            'tipo'    => 'success',
            'mensaje' => 'Finalizo la sesión con éxito!',
        ];

        return response()->json($data, 200);
    }

    //inicio
    public function inicio()
    {
        $data['menu'] = 1;

        // Para graficas
        $data['usuarios_activos']   = User::where('estado', 'activo')->count();
        $data['usuarios_inactivos'] = User::where('estado', 'inactivo')->count();
        $data['carreras_u']         = UnidadCarreraArea::count();

        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', '=', Auth::user()->id)
            ->first();
        $unidad_carrera = DB::table('rl_unidad_carrera')
            ->where('estado', '=', 'activo')
            ->get();
        $usuarios = null;
        $forms    = DB::table('rl_formulado_tipo')->where('estado', '=', 'activo')->get();
        if ($rol->name == 'usuario') {
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

        $gestions = Gestion::where('estado', 'activo')->get();

        $data['unidad_carrera'] = $unidad_carrera;
        $data['forms']          = $forms;
        $data['formulados']     = $formulados;
        $data['mots']           = $mots;
        $data['futs']           = $futs;
        $data['gestions']       = $gestions;
        $data['gestiones']      = $gestiones;
        $data['usuarios']       = $usuarios;

        return view('inicio', $data);
    }

    /**
     * GRAFICOS
     */

    // Montos por gestión
    public function ver_gestion_gastos(Request $req)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $gestions = $req->gestions;
        $gestion  = Gestion::find($gestions);

        if (! $gestion) {
            return response()->json(['sumas_gestion' => []]);
        }

        $años = range($gestion->inicio_gestion, $gestion->fin_gestion);

        $query = DB::table('rl_gestiones as ges')
            ->join('rl_configuracion_formulado as config', 'config.gestiones_id', '=', 'ges.id')
            ->join('rl_formulario5 as f5', 'f5.configFormulado_id', '=', 'config.id')
            ->join('rl_medida_bienservicio as mbs', 'mbs.formulario5_id', '=', 'f5.id')
            ->where('ges.id_gestion', $gestions)
            ->select(
                'ges.gestion',
                DB::raw('SUM(mbs.total_monto) as total_monto_sum'),
                DB::raw('SUM(mbs.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(mbs.total_monto) - SUM(mbs.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('ges.gestion');

        if ($rol->name === 'usuario') {
            $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
        }

        $suma_por_gestion = $query->get()->keyBy('gestion');

        $sumas_gestion_final = collect($años)->map(function ($anio) use ($suma_por_gestion) {
            $datos = $suma_por_gestion->get($anio);
            return [
                'gestion'               => $anio,
                'total_monto_sum'       => $datos->total_monto_sum ?? 0,
                'total_presupuesto_sum' => $datos->total_presupuesto_sum ?? 0,
                'total_usado_sum'       => $datos->total_usado_sum ?? 0,
            ];
        });

        return response()->json($sumas_gestion_final);
    }

    // Montos por financiamiento
    public function ver_financiamiento_gastos(Request $req)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $gestion = $req->gestion;

        $todas_fuentes = DB::table('rl_financiamiento_tipo')->pluck('descripcion');

        $query = DB::table('rl_financiamiento_tipo as ft')
            ->leftJoin('rl_medida_bienservicio as mbs', 'mbs.tipo_financiamiento_id', '=', 'ft.id')
            ->leftJoin('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->leftJoin('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->leftJoin('rl_gestiones as ges', 'ges.id', '=', 'config.gestiones_id')
            ->where('ges.id', $gestion)
            ->select(
                'ft.descripcion',
                DB::raw('COALESCE(SUM(mbs.total_monto), 0) as total_monto_sum'),
                DB::raw('COALESCE(SUM(mbs.total_presupuesto), 0) as total_presupuesto_sum'),
                DB::raw('COALESCE(SUM(mbs.total_monto) - SUM(mbs.total_presupuesto), 0) as total_usado_sum')
            )
            ->groupBy('ft.descripcion');

        if ($rol->name === 'usuario') {
            $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
        }

        $sumas = $query->get()->keyBy('descripcion');

        $resultado_final = collect($todas_fuentes)->map(function ($fuente) use ($sumas) {
            $val = $sumas->get($fuente);
            return [
                'descripcion'           => $fuente,
                'total_monto_sum'       => $val->total_monto_sum ?? 0,
                'total_presupuesto_sum' => $val->total_presupuesto_sum ?? 0,
                'total_usado_sum'       => $val->total_usado_sum ?? 0,
            ];
        });

        return response()->json($resultado_final->values());
    }

    // Montos por partidas
    public function ver_partidas_gastos(Request $req)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $gestion = $req->gestion;

        $q3 = Medida_bienservicio::join('detalleTercerClasi_medida_bn as detalle_mbs3', 'detalle_mbs3.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiTercero as detalle3', 'detalle3.id', '=', 'detalle_mbs3.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as clasi3', 'clasi3.id', '=', 'detalle3.tercerclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->when($rol->name === 'usuario', function ($query) {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            })
            ->select(
                'clasi3.codigo',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('clasi3.codigo');

        $q4 = Medida_bienservicio::join('detalleCuartoClasi_medida_bn as detalle_mbs4', 'detalle_mbs4.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiCuarto as detalle4', 'detalle4.id', '=', 'detalle_mbs4.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as clasi4', 'clasi4.id', '=', 'detalle4.cuartoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->when($rol->name === 'usuario', function ($query) {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            })
            ->select(
                'clasi4.codigo',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('clasi4.codigo');

        $q5 = Medida_bienservicio::join('detalleQuintoClasi_medida_bn as detalle_mbs5', 'detalle_mbs5.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiQuinto as detalle5', 'detalle5.id', '=', 'detalle_mbs5.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as clasi5', 'clasi5.id', '=', 'detalle5.quintoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->when($rol->name === 'usuario', function ($query) {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            })
            ->select(
                'clasi5.codigo',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('clasi5.codigo');

        $union = $q3->unionAll($q4)->unionAll($q5);

        $sumas_partidas = DB::table(DB::raw("({$union->toSql()}) as u"))
            ->mergeBindings($union->getQuery())
            ->select(
                'codigo',
                DB::raw('SUM(total_monto_sum) as total_monto_sum'),
                DB::raw('SUM(total_presupuesto_sum) as total_presupuesto_sum'),
                DB::raw('SUM(total_usado_sum) as total_usado_sum')
            )
            ->groupBy('codigo')
            ->orderByDesc('total_monto_sum')
            ->get()
            ->sortBy('codigo')
            ->values();

        return response()->json($sumas_partidas);
    }

    // Montos por carreras
    public function ver_carreras_gastos(Request $req)
    {
        $gestion = $req->gestion;
        $rol     = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $base = function () use ($gestion, $rol) {
            $query = Medida_bienservicio::join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'f5.unidadCarrera_id')
                ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
                ->where('config.gestiones_id', $gestion);

            if ($rol->name == 'usuario') {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            }

            return $query;
        };

        $q3 = $base()
            ->join('detalleTercerClasi_medida_bn as detalle_mbs3', 'detalle_mbs3.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiTercero as detalle3', 'detalle3.id', '=', 'detalle_mbs3.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as clasi3', 'clasi3.id', '=', 'detalle3.tercerclasificador_id')
            ->select(
                'uc.id',
                'uc.nombre_completo as carrera',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('uc.id', 'uc.nombre_completo');

        $q4 = $base()
            ->join('detalleCuartoClasi_medida_bn as detalle_mbs4', 'detalle_mbs4.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiCuarto as detalle4', 'detalle4.id', '=', 'detalle_mbs4.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as clasi4', 'clasi4.id', '=', 'detalle4.cuartoclasificador_id')
            ->select(
                'uc.id',
                'uc.nombre_completo as carrera',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('uc.id', 'uc.nombre_completo');

        $q5 = $base()
            ->join('detalleQuintoClasi_medida_bn as detalle_mbs5', 'detalle_mbs5.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiQuinto as detalle5', 'detalle5.id', '=', 'detalle_mbs5.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as clasi5', 'clasi5.id', '=', 'detalle5.quintoclasificador_id')
            ->select(
                'uc.id',
                'uc.nombre_completo as carrera',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_presupuesto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_usado_sum')
            )
            ->groupBy('uc.id', 'uc.nombre_completo');

        $union = $q3->unionAll($q4)->unionAll($q5);

        $sumas_carrera = DB::table(DB::raw("({$union->toSql()}) as u"))
            ->mergeBindings($union->getQuery())
            ->select(
                'carrera',
                DB::raw('SUM(total_monto_sum) as total_monto_sum'),
                DB::raw('SUM(total_presupuesto_sum) as total_presupuesto_sum'),
                DB::raw('SUM(total_usado_sum) as total_usado_sum')
            )
            ->groupBy('carrera')
            ->orderByDesc('total_monto_sum')
            ->limit(15)
            ->get();

        return response()->json($sumas_carrera);
    }

    // para
    public function ver_formularios_can(Request $request)
    {
        $formulario1 = Formulario1::distinct('configFormulado_id')->count('configFormulado_id');
        $formulario2 = Formulario2::distinct('configFormulado_id')->count('configFormulado_id');
        $formulario4 = Formulario4::distinct('configFormulado_id')->count('configFormulado_id');
        $formulario5 = Formulario5::distinct('configFormulado_id')->count('configFormulado_id');
        $data        = [
            'formulario1' => $formulario1,
            'formulario2' => $formulario2,
            'formulario4' => $formulario4,
            'formulario5' => $formulario5,
        ];

        return response()->json($data, 200);
    }

    //para la parte de captcha (ya no se usa)
    public function generateCaptchaImage()
    {
        $length      = 6; // Longitud del CAPTCHA
        $characters  = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
        $captchaText = '';
        // Genera el texto CAPTCHA aleatorio
        for ($i = 0; $i < $length; $i++) {
            $captchaText .= $characters[rand(0, strlen($characters) - 1)];
        }
        session()->put('captchaText_recuperado', $captchaText);
        return $captchaText;
    }
}
