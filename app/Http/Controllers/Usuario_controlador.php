<?php

namespace App\Http\Controllers;

use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Formulario5;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Usuario_controlador extends Controller{


    //validar usuario
    public function validar_usuario(Request $request){
        $mensaje = 'Usuario, contraseña o captcha invalidos';
        $valores = Validator::make($request->all(),[
            'usuario'   => 'required',
            'password'  => 'required',
            'captcha'   => 'required'
        ]);
        if($valores->fails()){
            $data=array(
                'tipo'=>'validacion',
                'mensaje'=>'Todos los campos son requeridos'
            );
        }else{
            //primero comprobamos capcha
            if($request->captcha==session()->get('captchaText_recuperado')){
                //comprobar si el usuario no ha sido eliminado o este inactivo
                $usuario = User::where('usuario','like', $request->usuario)->get();
                if($usuario){
                    if ( $token = Auth::attempt(['usuario' => $request->usuario, 'password' => $request->password, 'estado'=>'activo', 'deleted_at'=>NULL])) {
                        $request->session()->regenerate();

                        $data=array(
                            'tipo'=>'success',
                            'mensaje'=>'Inicio de session con exito!'
                        );
                    }else{
                        $data=array(
                            'tipo'=>'error',
                            'mensaje'=>$mensaje
                        );
                    }
                }else{
                    $data=array(
                        'tipo'=>'error',
                        'mensaje'=>$mensaje
                    );
                }
            }else{
                $data=array(
                    'tipo'=>'error',
                    'mensaje'=>$mensaje
                );
            }

        }
        return response()->json($data, 200);
    }

    //para cerrar session
    public function cerrar_session(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $data=array(
            'tipo'=>'success',
            'mensaje'=>'Finalizo la sesión con éxito!'
        );
        return response()->json($data, 200);
    }

    //inicio
    public function inicio(){
        $data['menu']=1;
        $data['usuarios_activos'] = User::where('estado', 'activo')->count();
        $data['usuarios_inactivos'] = User::where('estado', 'inactivo')->count();
        $data['carreras_u'] = UnidadCarreraArea::count();
        return view('inicio', $data);
    }

    //para ver
    public function ver_carrerasunidades(Request $request){
        $tipo_carrera = Tipo_CarreraUnidad::withCount('carrera_unidad_area')->get();
        $data=array(
            'tipo_carrera'=>$tipo_carrera
        );
        return response()->json($data);
    }
    //opara
    public function ver_formularios_can(Request $request){
        $formulario1 = Formulario1::count();
        $formulario2 = Formulario2::count();
        $formulario4 = Formulario4::count();
        $formulario5 = Formulario5::count();
        $data=array(
            'formulario1'=>$formulario1,
            'formulario2'=>$formulario2,
            'formulario4'=>$formulario4,
            'formulario5'=>$formulario5,
        );
        return response()->json($data, 200);
    }


    //para la parte de captcha
    public function generateCaptchaImage(){
        $length = 6; // Longitud del CAPTCHA
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $captchaText = '';
        // Genera el texto CAPTCHA aleatorio
        for ($i = 0; $i < $length; $i++) {
            $captchaText .= $characters[rand(0, strlen($characters) - 1)];
        }
        session()->put('captchaText_recuperado', $captchaText);
        return $captchaText;
    }
}
