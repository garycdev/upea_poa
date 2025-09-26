<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Admin_caja\Caja;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestion;
use App\Models\Gestiones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin_caja\Historial_caja;
use Illuminate\Support\Facades\Auth;

class Controlador_asignarFinanciamiento extends Controller{
    //para asignar el financiamiento
    public function asignarFinanciamiento(){
        $data['menu']       = '11';
        $data['gestiones']    = Gestiones::where('estado', 'activo')->get();
        return view('administrador.configuracion_poa.asignar_financiamiento',$data);
    }
    //para listar las gestiones especificas
    public function listar_gestiones(Request $request){
        if($request->ajax()){
            $gestion        = Gestion::find($request->id);
            $gestiones      = $gestion->relacion_gestiones()->where('estado', 'activo')->get();
            if($gestiones){
                $data=mensaje_array('success', $gestiones);
            }else{
                $data = mensaje_array('error', 'No se encontro ningun registro');
            }
            return response()->json($data, 200);
        }
    }
    //para listar el tipo de carrera que existe en la universidad publica de el alto
    public function listar_CarreraUnidad(Request $request){
        if($request->ajax()){
            $data['gestiones_lis']          = Gestiones::find($request->id);
            $data['tipoCarreraUnidadArea']  = Tipo_CarreraUnidad::orderBy('id','asc')->get();
            $data['menu']                   = '11';
            return view('administrador.configuracion_poa.detalles_CarreraUnidadArea', $data);
        }
    }
    //para listar si es de tipo carrera o unidad administrativa o area y asignar financiamiento
    public function asignar_financiamiento($id_carreraUnidadArea, $id_gestiones){
        $id_tipo_carrera        = desencriptar($id_carreraUnidadArea);
        $id_gestion             = desencriptar($id_gestiones);
        $gestiones_lis          = Gestiones::find($id_gestion);
        $tipo_carreraUnidadArea = Tipo_CarreraUnidad::find($id_tipo_carrera);
        $fuente_financiamiento  = Financiamiento_tipo::get();
        $data=array(
            'gestion_seleccionada'      =>  $gestiones_lis,
            'tipo_carreraUnidadArea'    =>  $tipo_carreraUnidadArea,
            'menu'                      => '11',
            'fuente_financiamiento'     =>  $fuente_financiamiento,
        );
        return view('administrador.configuracion_poa.financiamiento_gestion.financiamiento_gestion', $data);
    }
    //para listar cua si tiene
    public function listar_cua(Request $request){
        if($request->ajax()){
            $data['listar_carreraUnidadArea'] = UnidadCarreraArea::where('id_tipo_carrera', $request->id_tcau)
                                            ->orderBy('id', 'asc')
                                            ->get();
            $data['tipo_carrera_unidad'] = Tipo_CarreraUnidad::find($request->id_tcau);
            $id_gestion = $request->id_ges;
            $data['resultado'] = UnidadCarreraArea::with(['relacion_caja'=>function($query1) use ($id_gestion){
                                        $query1->where('gestiones_id', $id_gestion);
                                        $query1->with('financiamiento_tipo');
                                    }])->where('id_tipo_carrera', $request->id_tcau)
                                    ->orderBy('id', 'asc')
                                    ->get();
            $data['tipo_financiamiento'] = Financiamiento_tipo::get();
            return view('administrador.configuracion_poa.financiamiento_gestion.listado_cua',$data);
        }
    }

    //para buscar
    public function buscador_listado(Request $request){
        if($request->ajax()){
            $data['listar_carreraUnidadArea'] = UnidadCarreraArea::with('relacion_caja')->where('id_tipo_carrera', $request->id_tcau)
                                            ->orderBy('id', 'asc')
                                            ->get();

            $id_gestion                     = $request->id_ges;
            $nombre_buscar                  = $request->nombre;
            $data['tipo_carrera_unidad'] = Tipo_CarreraUnidad::find($request->id_tcau);
            $data['tipo_financiamiento'] = Financiamiento_tipo::get();
            $data['resultado'] = UnidadCarreraArea::with(['relacion_caja'=>function($query1) use ($id_gestion, $nombre_buscar){
                                        $query1->where('gestiones_id', $id_gestion);
                                    }])->where('id_tipo_carrera', $request->id_tcau)
                                    ->where('nombre_completo','like', '%'.$nombre_buscar.'%')
                                    ->orderBy('id', 'asc')
                                    ->get();
            return view('administrador.configuracion_poa.financiamiento_gestion.listado_cua',$data);
        }
    }

    //para asignar las el financiamiento
    public function caja_financiamientoCarrera(Request $request){
        if($request->ajax()){
            $data['carrera_unidad']             = UnidadCarreraArea::find($request->id);
            $data['caja_asignadaFinanciada']    = Caja::with('financiamiento_tipo')->where('gestiones_id', $request->id_gestiones)
                                ->where('unidad_carrera_id', $request->id)
                                ->get();
            return view('administrador.configuracion_poa.financiamiento_gestion.listado_financiamientoCaja', $data);
        }
    }
    //para guardar el financiamiento
    public function caja_finaCGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'tipo_de_financiamiento'    => 'required',
                'monto'                     => 'required',
                'documento_privado'         => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $saldo_recivido = sin_separador_comas($request->monto);

                $variable = '';
                if($request->id_caja != NULL){
                    $variable = 1;
                }else{
                    $variable = 0;
                }

                switch ($variable) {
                    case 0:
                        $validar_caja = Caja::where('gestiones_id', $request->gestiones_idSelec)
                                    ->where('unidad_carrera_id', $request->unidadCareraArea)
                                    ->where('financiamiento_tipo_id', $request->tipo_de_financiamiento)
                                    ->exists();
                        if($validar_caja){
                            $data = mensaje_array('error', 'Porfavor elija otro tipo de Financiamiento');
                        }else{
                            //vamos a recivir el pdf
                            $pdf            = $request->file('documento_privado');
                            $ruta_pdf       = 'documento_privado/';
                            $documento_priv = date('YmdHis').'.pdf';
                            $pdf->move($ruta_pdf, $documento_priv);


                            $caja = new Caja;
                            $caja->saldo                    = $saldo_recivido;
                            $caja->monto                    = $saldo_recivido;
                            $caja->fecha                    = date('Y-m-d');
                            $caja->gestiones_id             = $request->gestiones_idSelec;
                            $caja->unidad_carrera_id        = $request->unidadCareraArea;
                            $caja->documento_privado        = $documento_priv;
                            $caja->financiamiento_tipo_id   = $request->tipo_de_financiamiento;
                            $caja->usuario_id               = Auth::id();
                            $caja->save();

                            if($caja->id){

                                $fuente_financiamiento = Financiamiento_tipo::find($request->tipo_de_financiamiento);
                                $historial_caja                     = new Historial_caja;
                                $historial_caja->fecha              = date('Y-m-d');
                                $historial_caja->hora               = date('h:i:s');
                                $historial_caja->documento_privado  = $documento_priv;
                                $historial_caja->concepto           = $fuente_financiamiento->descripcion;
                                $historial_caja->saldo              = $saldo_recivido;
                                $historial_caja->caja_id            = $caja->id;
                                $historial_caja->usuario_id         = Auth::id();
                                $historial_caja->save();
                            }
                            if($caja->id){
                                $data = array(
                                    'tipo'=>'success',
                                    'mensaje'=>'Se inserto con éxito',
                                    'id_carreraC'=>$request->unidadCareraArea,
                                );
                            }else{
                                $data = mensaje_array('error', 'Ocurrio un error al insertar');
                            }
                        }
                    break;

                    case 1:

                        //vamos a recivir el pdf
                        $pdf            = $request->file('documento_privado');
                        $ruta_pdf       = 'documento_privado/';
                        $documento_priv = date('YmdHis').'.pdf';
                        $pdf->move($ruta_pdf, $documento_priv);

                        $caja = Caja::find($request->id_caja);
                        if($caja->financiamiento_tipo_id == $request->tipo_de_financiamiento){
                            $caja->saldo                    = $saldo_recivido;
                            $caja->documento_privado        = $documento_priv;
                            $caja->fecha                    = date('Y-m-d');
                            $caja->usuario_id               = Auth::id();
                            $caja->save();
                            if($caja->id){
                                $fuente_financiamiento = Financiamiento_tipo::find($request->tipo_de_financiamiento);
                                $historial_caja                     = new Historial_caja;
                                $historial_caja->fecha              = date('Y-m-d');
                                $historial_caja->hora               = date('h:i:s');
                                $historial_caja->documento_privado  = $documento_priv;
                                $historial_caja->concepto           = $fuente_financiamiento->descripcion;
                                $historial_caja->saldo              = $saldo_recivido;
                                $historial_caja->caja_id            = $caja->id;
                                $historial_caja->usuario_id         = Auth::id();
                                $historial_caja->save();
                            }
                            if($caja->id){
                                $data = array(
                                    'tipo'=>'success',
                                    'mensaje'=>'Se editó con éxito',
                                    'id_carreraC'=>$request->unidadCareraArea,
                                );
                            }else{
                                $data = mensaje_array('error', 'Ocurrio un error al insertar');
                            }
                        }else{
                            $data = mensaje_array('error', 'No puede seleccionar diferente fuente de financiamiento');
                        }
                    break;
                }


            }
            return response()->json($data, 200);
        }
    }

    //para editar el saldo
    public function caja_finaCEditar(Request $request){
        if($request->ajax()){
            $caja = Caja::find($request->id);
            if($caja){
                $data=array(
                    'tipo'=>'success',
                    'mensaje'=>$caja,
                    'monto_rec'=>con_separador_comas($caja->saldo)
                );
            }else{
                $data=mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }
}
