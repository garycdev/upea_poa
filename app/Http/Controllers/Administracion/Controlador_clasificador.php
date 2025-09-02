<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Clasificador\Clasificador_primero;
use App\Models\Clasificador\Clasificador_tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Clasificador\Clasificador_segundo;
use App\Models\Clasificador\Clasificador_tercero;
use App\Models\Clasificador\Clasificador_cuarto;
use App\Models\Clasificador\Clasificador_quinto;
use App\Models\Clasificador\Detalle_tercerClasificador;
use App\Models\Clasificador\Detalle_cuartoClasificador;
use App\Models\Clasificador\Detalle_quintoClasificador;
use Exception;

class Controlador_clasificador extends Controller{


    /**
     * TIPO DE CLASIFICADOR PRESUPUESTARIO
    */
    public function clasificador(){
        $data['menu'] = 9;
        return view('administrador.clasificador.clasificador', $data);
    }
    //para listar los clasificadores tipo
    public function clasificador_listar(){
        $data['clasificadores'] = Clasificador_tipo::get();
        return response()->json($data, 200);
    }
    //para cambiar el estado del clasificador presupuestario
    public function clasificador_estado(Request $request){
        if($request->ajax()){
            $clasificador = Clasificador_tipo::find($request->id);
            $estado = ($clasificador->estado=='activo')?'inactivo':'activo';
            $clasificador->estado = $estado;
            $clasificador->save();
            if($clasificador->id){
                $data=mensaje_array('success', 'Se cambio el estado del clasificador');
            }else{
                $data =mensaje_array('error', 'Ocurrio un error al cambiar el estado');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el clasificador presupuestario
    public function clasificador_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo'=>'required|unique:rl_clasificador_tipo,titulo',
                'descripcion'=>'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $clasificador               = new Clasificador_tipo;
                $clasificador->titulo       = $request->titulo;
                $clasificador->descripcion  = $request->descripcion;
                $clasificador->estado       = 'activo';
                $clasificador->save();
                if ($clasificador->id) {
                    $data=mensaje_array('success', 'Se inserto con éxito el tipo de Clasificador');
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al insertar el tipo de Clasificador');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para editar el clasificador presupuestario
    public function clasificador_editar(Request $request){
        if($request->ajax()){
            $clasificador = Clasificador_tipo::find($request->id);
            if($clasificador->id){
                $data=mensaje_array('success',$clasificador);
            }else{
                $data = mensaje_array('error', 'Ocurrio un problema al editar');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function clasificador_eguardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo_'       => 'required|unique:rl_clasificador_tipo,titulo,'.$request->id_clasificador,
                'descripcion_'  => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $clasificador               = Clasificador_tipo::find($request->id_clasificador);
                $clasificador->titulo       = $request->titulo_;
                $clasificador->descripcion  = $request->descripcion_;
                $clasificador->save();
                if($clasificador->id){
                    $data = mensaje_array('success', 'Se realizó la edición del tipo de clasificador con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al realizar la edición');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el registro
    public function clasificador_eliminar(Request $request){
        if($request->ajax()){
            try {
                $clasificador = Clasificador_tipo::find($request->id);
                if($clasificador->delete()){
                    $data = mensaje_array('success', 'Se elimino con exito el tipo de clasificador!');
                }else{
                    $data = mensaje_array('error','Ocurrio un problema al eliminar');
                }
            } catch (\Throwable $e) {
                $data = mensaje_array('error','Ocurrio un problema al eliminar ');
            }

            return response()->json($data, 200);
        }
    }
    /**
     * FIN DE TIPO DE CLASIFICADOR PRESUPUESTARIO
    */

    /**
     * DETALLES DE CLASIFICADOR
     */
    public function clasificador_detalles(Request $request){
        if($request->ajax()){
            $clasificador_tipo              = Clasificador_tipo::find($request->id);
            $data['clasificador_primero']   = $clasificador_tipo->clasificador_primero;
            return view('administrador.clasificador.detalles_clasificador', $data);
        }
    }

    /**PARA EL PRIMER CLASIFICADOR */
    public function primerCl(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo'    => 'required|min:1|max:5',
                'titulop'   => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                if($request->id_clasificadorPrimero != ''){
                    $clasificador_primero = Clasificador_primero::find($request->id_clasificadorPrimero);
                }else{
                    $clasificador_primero = new Clasificador_primero;
                }
                $clasificador_primero->codigo               = $request->codigo;
                $clasificador_primero->titulo               = $request->titulop;
                $clasificador_primero->descripcion          = $request->descripcionp;
                $clasificador_primero->id_clasificador_tipo = $request->id_clasificadorTipo;
                $clasificador_primero->save();
                if($clasificador_primero->id){
                    $data = array(
                        'tipo'=>'success',
                        'mensaje'=>'Se guardo con exito el primer Clasificador',
                        'id_tipoClasificador'=> $request->id_clasificadorTipo,
                    );
                }else{
                    $data=mensaje_array('error', 'Ocurrio un problema a insertar!');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar el primero clasificador
    public function primerCl_editar(Request $request){
        if($request->ajax()){
            $clasificador_primero = Clasificador_primero::find($request->id);
            if($clasificador_primero->id){
                $data = mensaje_array('success', $clasificador_primero);
            }else{
                $data = mensaje_array('error', 'No se pudo encontrar el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para elimianr el registro
    public function primerCl_eliminar(Request $request){
        if($request->ajax()){
            try {
                $clasificador_primero = Clasificador_primero::find($request->id);
                if($clasificador_primero->delete()){
                    $data = array(
                        'tipo'=>'success',
                        'mensaje'=>'Se elimino con éxito!'
                    );
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
            }
            return response()->json($data, 200);
        }
    }
    //para cambiar el estado del clasificador
    public function primerCl_estado(Request $request){
        if($request->ajax()){
            $clasificador_primero = Clasificador_primero::find($request->id);
            $estado = ($clasificador_primero->estado=='activo') ? 'inactivo' : 'activo';
            $clasificador_primero->estado = $estado;
            $clasificador_primero->save();
            if($clasificador_primero->id){
                $data = mensaje_array('success', 'Se cambio el estado con exito');
            }else{
                $data = mensaje_array('error', 'Ocurrio un problema al cambiar el estado');
            }
            return response()->json($data, 200);
        }
    }

    //PAR LA PARTE DEL SEGUNDO CLASIFICADOR
    public function detalles_clasificadorSegundo($id){
        $id_descrip = desencriptar($id);
        $data['menu'] = 9;
        $primer_clasificador = Clasificador_primero::find($id_descrip);


        $segundo_clasificador = Clasificador_segundo::where('id_clasificador_primero', $primer_clasificador->id)
                                ->orderBy('codigo','asc')
                                ->get();


        $tercer_clasificador = Clasificador_segundo::with('clasificador_tercero')
                                    ->where('id_clasificador_primero', $id_descrip)
                                    ->get();

        $cuarto_clasificador = Clasificador_segundo::with('clasificador_tercero.clasificador_cuarto')
                                    ->orderBy('codigo','asc')
                                    ->where('id_clasificador_primero', $id_descrip)
                                    ->get();

        $quinto_clasificador = Clasificador_segundo::with('clasificador_tercero.clasificador_cuarto.clasificador_quinto')
                                    ->where('id_clasificador_primero', $id_descrip)
                                    ->get();

        $data['primer_clasificador']    = $primer_clasificador;
        $data['segundo_clasificador']   = $segundo_clasificador;
        $data['tercer_clasificador']    = $tercer_clasificador;
        $data['cuarto_clasificador']    = $cuarto_clasificador;
        $data['quinto_clasificador']    = $quinto_clasificador;
        return view('administrador.clasificador.clasificador_detalles', $data);
    }




    //para la parte del segundo clasificador
    public function segundo_clasificador(Request $request){
        if($request->ajax()){
            $primer_clasificador    = Clasificador_primero::find($request->id);
            $codigo                 = substr(strval($primer_clasificador->codigo), 0,1);
            $segundo_clasificador   = Clasificador_segundo::where('id_clasificador_primero', $request->id)
                                    ->orderBy('codigo','asc')
                                    ->get();
            $data['listarSegundoClasificador']=$segundo_clasificador;
            $data['clasificadorPrimero1'] = $primer_clasificador;
            $data['codigo_ini'] = $codigo;
            return view('administrador.clasificador.secundarios.segundoClasificador',$data);
        }
    }

    //para guardar el segundo clasificador
    public function segundo_clasificadorGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo'        => 'required|min:4|max:4',
                'titulo'        => 'required',
                'descripcion'   => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $segundo_clasificador                           = new Clasificador_segundo;
                $segundo_clasificador->codigo                   = $request->primer_digitoSegundoClasificador.$request->codigo;
                $segundo_clasificador->titulo                   = $request->titulo;
                $segundo_clasificador->descripcion              = $request->descripcion;
                $segundo_clasificador->id_clasificador_primero  = $request->id_primerClasificador;
                $segundo_clasificador->save();
                if($segundo_clasificador->id){
                    $data = array(
                        'tipo'=>'success',
                        'mensaje'=>'se guardo con éxito!',
                        'id_clasi1'=>$request->id_primerClasificador
                    );
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al insertar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el segundo clasificador
    public function segundo_clasificadorEliminar(Request $request){
        if($request->ajax()){
            try {
                $segundo_clasificador = Clasificador_segundo::find($request->id);
                if($segundo_clasificador->delete()){
                    $data = mensaje_array('success', 'Se eliminó con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al eliminar!');
                }
            } catch (\Throwable $th) {
                $data=mensaje_array('error', 'Ocurrio un problema al eliminar!');
            }
            return response()->json($data, 200);
        }
    }
    //para editar el segundo clasificador
    public function segundo_clasificadorEditar(Request $request){
        if($request->ajax()){
            $segundo_clasificador = Clasificador_segundo::find($request->id);
            if($segundo_clasificador->id){
                $data=mensaje_array('success', $segundo_clasificador);
            }else{
                $data = mensaje_array('error', 'No se encontro el registro!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado del segundo clasificador
    public function segundo_clasificadorEditarGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo_'       => 'required|min:4|max:4',
                'titulo_'       => 'required',
                'descripcion_'  => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $segundo_clasificador               = Clasificador_segundo::find($request->id_SegundoClasificador);
                $segundo_clasificador->codigo       = $request->primer_digitoSegundoClasificador_edi.$request->codigo_;
                $segundo_clasificador->titulo       = $request->titulo_;
                $segundo_clasificador->descripcion  = $request->descripcion_;
                $segundo_clasificador->save();
                if($segundo_clasificador->id){
                    $data = mensaje_array('success', 'Se editó el segundo clasificador con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problea a guardar ');
                }
            }
            return response()->json($data, 200);
        }
    }

    /**
     * PARA EL TERCER CLASIFICADOR
    */
    public function tercer_clasificador(Request $request){
        if($request->ajax()){
            $tercer_clasificador = Clasificador_segundo::with('clasificador_tercero')
                                    ->where('id_clasificador_primero', $request->id)
                                    ->orderBy('codigo','asc')
                                    ->get();
            $data['listarTercerClasificador'] = $tercer_clasificador;
            return view('administrador.clasificador.secundarios.tercerClasificador', $data);
        }
    }

    //para verificadr del segundo clasificador
    public function verificarSegundoClasificador(Request $request){
        if($request->ajax()){
            $segundo_clasificador = Clasificador_segundo::find($request->id);
            if($segundo_clasificador->id){
                $primerosdosDigitos = substr(strval($segundo_clasificador->codigo),0, 2);
                $data=array(
                    'tipo'              => 'success',
                    'mensaje'           => 'Se econtro con exito',
                    'primerosdosDigitos'=> $primerosdosDigitos
                );
            }else{
                $data=mensaje_array('error', 'Ocurrio un error al buscar el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el tercer clasificador
    public function tercer_clasificadorGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'seleccioneSegundoClasificador' => 'required',
                'codigo___'                     => 'required|min:3|max:3',
                'titulo___'                     => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $tercer_clasificador                            = new Clasificador_tercero;
                $tercer_clasificador->codigo                    = $request->primerosDosDigitosEnviar.$request->codigo___;
                $tercer_clasificador->titulo                    = $request->titulo___;
                $tercer_clasificador->descripcion               = $request->descripcion___;
                $tercer_clasificador->id_clasificador_segundo   = $request->seleccioneSegundoClasificador;
                $tercer_clasificador->save();
                if($tercer_clasificador->id){
                    $data = mensaje_array('success', 'Se guardo con exito el tercer clasificador');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el tercer clasificador
    public function tercer_clasificadorEliminar(Request $request){
        if($request->ajax()){
            try {
                $tercer_clasificador = Clasificador_tercero::find($request->id);
                if($tercer_clasificador->delete()){
                    $data = mensaje_array('success', 'Se eliminó con éxito el tercer clasificador');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al eliminar');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error', 'Ocurrio un problema al eliminar');
            }
            return response()->json($data, 200);
        }
    }
    //para editar el tercer clasificador
    public function tercer_clasificadorEditar(Request $request){
        if($request->ajax()){
            $tercer_clasificador = Clasificador_tercero::find($request->id);
            if($tercer_clasificador->id){
                $primerosDosDigitos = substr(strval($tercer_clasificador->codigo), 0, 2);
                $ultimosTresDigitos = substr(strval($tercer_clasificador->codigo), -3);
                $data=array(
                    'tipo'                  => 'success',
                    'mensaje'               => $tercer_clasificador,
                    'primerosDosDigitos'    => $primerosDosDigitos,
                    'ultimosTresDigitos'    => $ultimosTresDigitos,
                );
            }else{
                $data=mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el editado de el tercer clasificador
    public function tercer_clasificadorEdGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'seleccioneSegundoClasificadorEditar'=>'required',
                'codigo____'=>'required|min:3|max:3',
                'titulo____'=>'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $tercer_clasificador                            = Clasificador_tercero::find($request->id_tercerClasificador);
                $tercer_clasificador->codigo                    = $request->primerosDosDigitosEnviar_edi.$request->codigo____;
                $tercer_clasificador->titulo                    = $request->titulo____;
                $tercer_clasificador->descripcion               = $request->descripcion____;
                $tercer_clasificador->id_clasificador_segundo = $request->seleccioneSegundoClasificadorEditar;
                $tercer_clasificador->save();
                if($tercer_clasificador->id){
                    $data = mensaje_array('success', 'Se editó con exito el tercer clasificador');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al guardar lo editado');
                }
            }
            return response()->json($data, 200);
        }
    }

    /**
     * PARA CUARTO CLASIFICADOR
    */
    public function cuarto_clasificador(Request $request){
        if($request->ajax()){
            $cuarto_clasificador = Clasificador_segundo::with('clasificador_tercero.clasificador_cuarto')
                                    ->orderBy('codigo','asc')
                                    ->where('id_clasificador_primero', $request->id)
                                    ->get();
            $data['listar_CuartoClasificador'] = $cuarto_clasificador;
            return view('administrador.clasificador.secundarios.cuartoClasificador', $data);
        }
    }
    //para listar de un determinado segundo clasificador todos los terceros
    public function tercer_clasificadorListar(Request $request){
        if($request->ajax()){
            $tercer_clasificador = Clasificador_tercero::where('id_clasificador_segundo', $request->id)->get();
            if($tercer_clasificador){
                $data=mensaje_array('success', $tercer_clasificador);
            }else{
                $data = mensaje_array('error', 'No hay registros');
            }
            return response()->json($data, 200);
        }
    }

    //para verificar o sacar los primero digitos
    public function verificar_tercerclasificador(Request $request){
        if($request->ajax()){
            $tercer_clasificador = Clasificador_tercero::find($request->id);
            if($tercer_clasificador != ''){
                $primerosTresDigitos = substr(strval($tercer_clasificador->codigo),0, 3);
                $data=array(
                    'tipo'                  => 'success',
                    'mensaje'               => 'Se econtro con exito',
                    'primerostresDigitos'   => $primerosTresDigitos
                );
            }else{
                $data=mensaje_array('error', 'Ocurrio un error al buscar el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el cuarto clasificador
    public function cuarto_clasificadorGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'seleccionarSegundoClasificador_'   => 'required',
                'seleccionarTercerClasificador'     => 'required',
                'codigo_____'                       => 'required|min:2|max:2',
                'titulo_____'                       => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $cuarto_clasificador                            = new Clasificador_cuarto;
                $cuarto_clasificador->codigo                    = $request->primerosTresDigitosEnviar.$request->codigo_____;
                $cuarto_clasificador->titulo                    = $request->titulo_____;
                $cuarto_clasificador->descripcion               = $request->descripcion_____;
                $cuarto_clasificador->id_clasificador_tercero   = $request->seleccionarTercerClasificador;
                $cuarto_clasificador->save();
                if($cuarto_clasificador->id){
                    $data = mensaje_array('success', 'Se guardo con exito el cuarto clasificador');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar el cuarto clasificador
    public function cuarto_clasificadorEditar(Request $request){
        if($request->ajax()){
            $cuarto_clasificador            = Clasificador_cuarto::find($request->id);
            $listar_clasificadorTerceroR    = Clasificador_tercero::where('id_clasificador_segundo', $request->idSegundo_clasi)->get();
            if($cuarto_clasificador->id){
                $tercer_clasificador    = $cuarto_clasificador->clasificador_tercero;
                $primerosTresDigitos    = substr(strval($cuarto_clasificador->codigo),0, 3);
                $ultimosDosDigitos      = substr($cuarto_clasificador->codigo, -2);
                $data = array(
                    'tipo'                          => 'success',
                    'mensaje'                       => $cuarto_clasificador,
                    'primerosTresDigitos'           => $primerosTresDigitos,
                    'ultimosDosDigitos'             => $ultimosDosDigitos,
                    'clasificador_terceroSegundoId' => $tercer_clasificador->id_clasificador_segundo,
                    'listar_clasificadorTerceroR'   => $listar_clasificadorTerceroR
                );
            }else{
                $data = mensaje_array('error', 'Ocurrio un error a obtenr los datos');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el cuarto clasificador editado
    public function cuarto_clasificadorEGuardar(Request $request){
        $validar = Validator::make($request->all(), [
            'seleccionarSegundoClasificadorEditar'  => 'required',
            'seleccionarTercerClasificadorEditar'   => 'required',
            'codigo______'                          => 'required|min:2|max:2',
            'titulo______'                          => 'required',
        ]);
        if($validar->fails()){
            $data = mensaje_array('errores',$validar->errors());
        }else{
            $cuarto_clasificador                            = Clasificador_cuarto::find($request->idCuartoClasificadorEditar);
            $cuarto_clasificador->codigo                    = $request->primerosTresDigitosEnviar_editar.$request->codigo______;
            $cuarto_clasificador->titulo                    = $request->titulo______;
            $cuarto_clasificador->descripcion               = $request->descripcion______;
            $cuarto_clasificador->id_clasificador_tercero   = $request->seleccionarTercerClasificadorEditar;
            $cuarto_clasificador->save();
            if($cuarto_clasificador->id){
                $data = mensaje_array('success', 'Se editó con exito el cuarto clasificador');
            }else{
                $data = mensaje_array('error', 'Ocurrio un problema al editar');
            }
        }
        return response()->json($data);
    }
    //para eliminar el cuarto clasificador
    public function cuarto_clasificadorEliminar(Request $request){
        if($request->ajax()){
            try {
                $cuarto_clasificador = Clasificador_cuarto::find($request->id);
                if($cuarto_clasificador->delete()){
                    $data = mensaje_array('success', 'Se eliminó con éxito el cuarto clasificador!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar');
            }
            return response()->json($data, 200);
        }
    }

    //TODO LO QUE ES EL QUINTO CLASIFICADOR
    public function quinto_clasificador(Request $request){
        if($request->ajax()){
            $quinto_clasificador = Clasificador_segundo::with('clasificador_tercero.clasificador_cuarto.clasificador_quinto')
                                    ->orderBy('codigo','asc')
                                    ->where('id_clasificador_primero', $request->id)
                                    ->get();
            $data['listar_QuintoClasificador'] = $quinto_clasificador;
            return view('administrador.clasificador.secundarios.quintoClasificador', $data);
        }
    }
    //listar el cuarto clasificador segun el tercer clasificador
    public function cuarto_clasificadorListar(Request $request){
        if($request->ajax()){
            $cuarto_clasificador = Clasificador_cuarto::where('id_clasificador_tercero', $request->id)->get();
            if($cuarto_clasificador){
                $data=mensaje_array('success', $cuarto_clasificador);
            }else{
                $data = mensaje_array('error', 'No hay registros');
            }
            return response()->json($data, 200);
        }
    }
    //para sacar los 4 digitos del cuarto clasificador
    public function cuarto_clasificadorCuatroDigitos(Request $request){
        if($request->ajax()){
            $cuarto_clasificador = Clasificador_cuarto::find($request->id);

            if($cuarto_clasificador){
                $primerosCuatroDigitos = substr($cuarto_clasificador->codigo, 0, 4);
                $data=array(
                    'tipo'=>'success',
                    'primerosCuatroDigitos'=>$primerosCuatroDigitos,
                );
            }else{
                $data = mensaje_array('error', 'No hay registros');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el quinto clasificador
    public function quinto_clasificadorGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'seleccionarSegundoClasificador__'  => 'required',
                'seleccionarTercerClasificador_'    => 'required',
                'seleccionarCuartoClasificador'     => 'required',
                'codigo_______'                     => 'required|min:1|max:1',
                'titulo_______'                     => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $quinto_clasificador                            = new Clasificador_quinto;
                $quinto_clasificador->codigo                    = $request->primerosCuatroDigitosEnviar.$request->codigo_______;
                $quinto_clasificador->titulo                    = $request->titulo_______;
                $quinto_clasificador->descripcion               = $request->descripcion_______;
                $quinto_clasificador->id_clasificador_cuarto    = $request->seleccionarCuartoClasificador;
                $quinto_clasificador->save();
                if($quinto_clasificador->id){
                    $data = mensaje_array('success', 'Se inserto el quinto clasificador con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurio un problema al insertar el registro');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para editar el quinto clasificador
    public function quinto_clasificadorEditar(Request $request){
        if($request->ajax()){
            $tercer_clasificador = Clasificador_tercero::where('id_clasificador_segundo', $request->id_segundoClasificador)->get();
            $cuarto_clasificador = Clasificador_cuarto::where('id_clasificador_tercero', $request->id_tercerClasificador)->get();
            $quinto_clasificador = Clasificador_quinto::find($request->id);
            $primerosCuatroDigitos = substr(strval($quinto_clasificador->codigo),0, 4);
            $ultimoDigito = substr($quinto_clasificador->codigo, -1);
            $data = array(
                'tipo'                          => 'success',
                'primerosCuatroDigitos'         => $primerosCuatroDigitos,
                'ultimoDigito'                  => $ultimoDigito,
                'mensaje'                       => $quinto_clasificador,
                'id_clasificadorSegundoEditar'  => $request->id_segundoClasificador,
                'tercerClasificadorEditar'      => $tercer_clasificador,
                'cuartoClasificadorEditar'      => $cuarto_clasificador,
            );

            return response()->json($data, 200);
        }
    }
    //para guardar lo editado en el quinto clasificador
    public function quinto_clasificadorEGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'seleccionarSegundoClasificador___'         => 'required',
                'seleccionarTercerClasificadorEditar___'    => 'required',
                'seleccionarCuartoClasificadorEditar_'      => 'required',
                'codigo________'                            => 'required|min:1|max:1',
                'titulo________'                            => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $quinto_clasificador                            = Clasificador_quinto::find($request->idClasificadorQuinto);
                $quinto_clasificador->codigo                    = $request->primerosCuatroDigitosEnviarEditar.$request->codigo________;
                $quinto_clasificador->titulo                    = $request->titulo________;
                $quinto_clasificador->descripcion               = $request->descripcion________;
                $quinto_clasificador->id_clasificador_cuarto    = $request->seleccionarCuartoClasificadorEditar_;
                $quinto_clasificador->save();
                if($quinto_clasificador->id){
                    $data = mensaje_array('success', 'Se inserto el quinto clasificador con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurio un problema al insertar el registro');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el quinto clasificador
    public function quinto_clasificadorEliminar(Request $request){
        if($request->ajax()){
            try {
                $quinto_clasificador = Clasificador_quinto::find($request->id);
                if($quinto_clasificador->delete()){
                    $data = mensaje_array('success', 'Se eliminó con éxito el quinto clasificador!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
            }
            return response()->json($data);
        }
    }
    /**
     * FIN DE DETALLES DE CLASIFICADOR
     */








    /**
     * PARA LOS DETALLES DEL TERCER CLASIFICADOR
    */
    public function listar_detallesTercerClasificador(Request $request){
        if($request->ajax()){
            $tercer_clasificador = Clasificador_tercero::with('detalle_tercerclasificador')->find($request->id);
            if($tercer_clasificador){
                $data = mensaje_array('success', $tercer_clasificador);
            }else{
                $data = mensaje_array('error', 'Ocurrio un error a listar los datos');
            }
            return response()->json($data, 200);
        }
    }
    //par aguardar detalles del tercer clasificador
    public function guardar_detallesTercerClasificador(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo_detalle' => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                if($request->id_tercerClasificadorDetalle_edi == '' && $request->id_tercerClasificadorDetalle_edi == NULL){
                    $detalle_tercerClasificador                         = new Detalle_tercerClasificador;
                    $detalle_tercerClasificador->tercerclasificador_id  = $request->id_tercerClasificadorDetalle_new;
                    $detalle_tercerClasificador->estado                 = 'activo';
                }else{
                    $detalle_tercerClasificador = Detalle_tercerClasificador::find($request->id_tercerClasificadorDetalle_edi);
                }
                $detalle_tercerClasificador->titulo                 = $request->titulo_detalle;
                $detalle_tercerClasificador->descripcion            = $request->descripcion_detalle;
                $detalle_tercerClasificador->save();
                if($detalle_tercerClasificador->id){
                    $data = array(
                        'tipo'                      => 'success',
                        'mensaje'                   => 'Se inserto con exito',
                        'id_clasificadorTerceroDet' => $request->id_tercerClasificadorDetalle_new
                    );
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para la edicion de detalles del tercer clasificador
    public function editar_detallesTercerClasificador(Request $request){
        if($request->ajax()){
            $detalle_tercerClasificador = Detalle_tercerClasificador::find($request->id);
            if($detalle_tercerClasificador){
                $data = mensaje_array('success', $detalle_tercerClasificador);
            }else{
                $data = mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }

    //para el estado del tercer clasificador
    public function estadodetallesTercerClasificador(Request $request){
        if($request->ajax()){
            $detalle_tercer_clasificador = Detalle_tercerClasificador::find($request->id);
            $estado = ($detalle_tercer_clasificador->estado == 'activo') ? 'inactivo':'activo';
            $id_tercer_clasificador                 = $detalle_tercer_clasificador->tercerclasificador_id;
            $detalle_tercer_clasificador->estado    = $estado;
            $detalle_tercer_clasificador->save();
            if($detalle_tercer_clasificador->id){
                $data=array(
                    'tipo'=>'success',
                    'mensaje'=>'Se cambio el estado del detalle del tercer clasificador!',
                    'id_tercerClasificador_r'=>$id_tercer_clasificador
                );
            }else{
                $data=mensaje_array('error', 'Se cambio el estado con éxito!');
            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN DE DETALLES DEL TECER CLASIFICADOR
     */

     /**
      * DETALLES DEL CUARTO CLASIFICADOR
      */
    public function listar_detallescuartoClasificador(Request $request){
        if($request->ajax()){
            if($request->ajax()){
                $cuarto_clasificador = Clasificador_cuarto::with('detalle_cuarto_clasificador')->find($request->id);
                if($cuarto_clasificador){
                    $data = mensaje_array('success', $cuarto_clasificador);
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error a listar los datos');
                }
                return response()->json($data, 200);
            }
        }
    }
    //para guardar detalles cuarto clasificador
    public function guardar_detallescuartoClasificador(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo_detalle_' => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                if($request->id_cuartoClasificadorDetalle_edi == '' && $request->id_cuartoClasificadorDetalle_edi == NULL){
                    $detalle_cuartoClasificador = new Detalle_cuartoClasificador;
                    $detalle_cuartoClasificador->cuartoclasificador_id  = $request->id_cuartoClasificadorDetalle_new;
                    $detalle_cuartoClasificador->estado                 = 'activo';
                }else{
                    $detalle_cuartoClasificador = Detalle_cuartoClasificador::find($request->id_cuartoClasificadorDetalle_edi);
                }
                $detalle_cuartoClasificador->titulo                 = $request->titulo_detalle_;
                $detalle_cuartoClasificador->descripcion            = $request->descripcion_detalle_;
                $detalle_cuartoClasificador->save();
                if($detalle_cuartoClasificador->id){
                    $data = array(
                        'tipo'                      => 'success',
                        'mensaje'                   => 'Se inserto con exito',
                        'id_clasificadorCuartoDet'  => $request->id_cuartoClasificadorDetalle_new
                    );
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function editar_detallescuartoClasificador(Request $request){
        if($request->ajax()){
            $detalle_cuartoClasificador = Detalle_cuartoClasificador::find($request->id);
            if($detalle_cuartoClasificador){
                $data = mensaje_array('success', $detalle_cuartoClasificador);
            }else{
                $data = mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }

    //para el estado del tercer clasificador
    public function estadodetallesCuartoClasificador(Request $request){
        if($request->ajax()){
            $detalle_cuarto_clasificador = Detalle_cuartoClasificador::find($request->id);
            $estado = ($detalle_cuarto_clasificador->estado == 'activo') ? 'inactivo':'activo';
            $id_cuarto_clasificador                 = $detalle_cuarto_clasificador->cuartoclasificador_id;
            $detalle_cuarto_clasificador->estado    = $estado;
            $detalle_cuarto_clasificador->save();
            if($detalle_cuarto_clasificador->id){
                $data=array(
                    'tipo'=>'success',
                    'mensaje'=>'Se cambio el estado del detalle del cuarto clasificador!',
                    'id_cuartoClasificador_r'=>$id_cuarto_clasificador
                );
            }else{
                $data=mensaje_array('error', 'Se cambio el estado con éxito!');
            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN DEL CUARTO CLASIFICADOR
     */

    /**
      *DETALLES DEL QUINTO CLASIFICADOR
    */
    //para listar
    public function listar_detallesquintoClasificador(Request $request){
        if($request->ajax()){
            if($request->ajax()){
                $quinto_clasificador = Clasificador_quinto::with('detalle_quinto_clasificador')->find($request->id);
                if($quinto_clasificador){
                    $data = mensaje_array('success', $quinto_clasificador);
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error a listar los datos');
                }
                return response()->json($data, 200);
            }
        }
    }
    public function guardar_detallesquintoClasificador(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo_detalle__' => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                if($request->id_quintoClasificadorDetalle_edi == '' && $request->id_quintoClasificadorDetalle_edi == NULL){
                    $detalle_quintoClasificador = new Detalle_quintoClasificador;
                    $detalle_quintoClasificador->quintoclasificador_id  = $request->id_quintoClasificadorDetalle_new;
                    $detalle_quintoClasificador->estado                 = 'activo';
                }else{
                    $detalle_quintoClasificador = Detalle_quintoClasificador::find($request->id_quintoClasificadorDetalle_edi);
                }
                $detalle_quintoClasificador->titulo                 = $request->titulo_detalle__;
                $detalle_quintoClasificador->descripcion            = $request->descripcion_detalle__;
                $detalle_quintoClasificador->save();
                if($detalle_quintoClasificador->id){
                    $data = array(
                        'tipo'                      => 'success',
                        'mensaje'                   => 'Se inserto con exito',
                        'id_clasificadorQuintoDet'  => $request->id_quintoClasificadorDetalle_new
                    );
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar
    public function editar_detallesquintoClasificador(Request $request){
        if($request->ajax()){
            $detalle_quintoClasificador = Detalle_quintoClasificador::find($request->id);
            if($detalle_quintoClasificador){
                $data = mensaje_array('success', $detalle_quintoClasificador);
            }else{
                $data = mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para cambiar el estado
    public function estadodetallesQuintoClasificador(Request $request){
        if($request->ajax()){
            $detalle_quinto_clasificador = Detalle_quintoClasificador::find($request->id);
            $estado = ($detalle_quinto_clasificador->estado == 'activo') ? 'inactivo':'activo';
            $id_quinto_clasificador                 = $detalle_quinto_clasificador->quintoclasificador_id;
            $detalle_quinto_clasificador->estado    = $estado;
            $detalle_quinto_clasificador->save();
            if($detalle_quinto_clasificador->id){
                $data=array(
                    'tipo'=>'success',
                    'mensaje'=>'Se cambio el estado del detalle del quinto clasificador!',
                    'id_quintoClasificador_r'=>$id_quinto_clasificador
                );
            }else{
                $data=mensaje_array('error', 'Se cambio el estado con éxito!');
            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN DE DETALLES DEL QUINTO CLASIFICADOR
     */
}
