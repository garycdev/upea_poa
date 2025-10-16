<?php
namespace App\Http\Controllers;

use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestiones;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Formulario5;
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
        $data['menu']               = 1;

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

        $data['unidad_carrera'] = $unidad_carrera;
        $data['forms']          = $forms;
        $data['formulados']     = $formulados;
        $data['mots']           = $mots;
        $data['futs']           = $futs;
        $data['gestiones']      = $gestiones;
        $data['usuarios']       = $usuarios;

        return view('inicio', $data);
    }

    // para ver 
    public function ver_carrerasunidades(Request $request)
    {
        $tipo_carrera = Tipo_CarreraUnidad::withCount('carrera_unidad_area')->get();
        $data         = [
            'tipo_carrera' => $tipo_carrera,
        ];
        return response()->json($data);
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
