<?php

namespace App\Http\Controllers\Formulacion;

use App\Http\Controllers\Controller;
use App\Models\Areas_estrategicas;
use App\Models\Configuracion\Categoria;
use App\Models\Configuracion\Formulado_tipo;
use App\Models\Configuracion\Tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Gestion;
use App\Models\Gestiones;
use App\Models\Pdes\Pdes_articulacion;
use App\Models\Pdu\Objetivo_estrategico;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Matriz_planificacion;
use App\Models\Pei\Objetivo_estrategico_sub;
use App\Models\Pei\Objetivo_institucional;
use App\Models\Poa\BienNServicio;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_formulacion extends Controller
{

    public function formulacion_poa(){
        $data['menu'] = 13;
        if(Auth::user()->id_unidad_carrera != NULL){
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['gestion']        = Gestion::get();
            return view('formulacion.formulacion_poa', $data);
        }else{
            $data['tipo_error'] = 'NOTA!';
            $data['mensaje']    = 'Lo siento no tiene acceso!';
            return view('formulacion.errores.formulacion_error',$data);
        }
    }
    //para listar las gestiones
    public function listarGestionesSP(Request $request){
        if($request->ajax()){
            //-----------------------------------------------------------------------
            $fecha_actual = date('Y-m-d');
            $configuracion_poa = Configuracion_formulado::with('formulado_tipo')->where('gestiones_id', $request->id)
                                ->get();
            $gestiones = Gestiones::find($request->id);
            //PARA REZALIZARLO CON FECHAS
            /* $configuracion_poa = Configuracion_formulado::with('formulado_tipo')
                                ->where('gestiones_id', $request->id)
                                ->where('fecha_inicial', '<=', $fecha_actual)
                                ->where('fecha_final', '>=', $fecha_actual)
                                ->get(); */
            if(count($configuracion_poa)>0){
                $data['configuracion_poa']=$configuracion_poa;
                $data['gestiones'] = $gestiones;
                return view('formulacion.formulaciones.listar_formulacionesTipo',$data);
            }else{
                echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Nota : </strong>A la gestión '.$gestiones->gestion.' No se le asigno aun ningun tipo de formulado
                </div>';
            }
        }
    }
    //para formulacion del poa
    public function formulacionPOA($formuladoConf_id, $gestiones_id){
        //recivimos los datos enviados de la URL y desencriptamos
        $id_formuladoConf       = desencriptar($formuladoConf_id);
        $id_gestiones           = desencriptar($gestiones_id);
        //nos servira para imprimir en pdf
        $data['id_configuracion_formulado'] = $id_formuladoConf;
        $data['id_gestiones'] = $id_gestiones;
        //nos servisa para imprimir en pdf
        //listamos las gestiones
        $gestiones                  = Gestiones::find($id_gestiones);
        $gestion                    = Gestion::find($gestiones->id_gestion);
        $configuracion_poa          = Configuracion_formulado::find($id_formuladoConf);
        $data['gestion']            = $gestion;
        $data['areas_estrategicas'] = $gestion->relacion_areas_estrategicas;
        $data['configuracion_poa']  = $configuracion_poa;
        $data['formulado_tipo']     = $configuracion_poa->formulado_tipo;
        $data['gestiones']          = $gestiones;
        //mandamos el menu y el tipo de carrera
        $carrera_unidad             = UnidadCarreraArea::find(Auth::user()->id_unidad_carrera);
        $data['carrera_unidad']     = $carrera_unidad;
        $data['menu']               = 13;
        //PRIMERO REALIZAREMOS POR TIPO DE FORMULADOS
        switch($configuracion_poa->formulado_id){
            case '1':
                $data['Rformulado_tipo']    = 1;
                $formulario1_Existe         = $configuracion_poa->formulario1()->where('unidadCarrera_id',Auth::user()->id_unidad_carrera)->get();
                if(count($formulario1_Existe)==0){
                    $data['resultado']='0';
                }else{
                    $data['resultado']='1';
                    $formulario1_es                         = $configuracion_poa->formulario1()->where('unidadCarrera_id',Auth::user()->id_unidad_carrera)->get();
                    $formulario1                            = Formulario1::find($formulario1_es[0]->id);
                    $formulario1_areasEstrategicas          = $formulario1->relacion_areasEstrategicas;
                    $data['formulario1']                    = $formulario1;
                    $data['formulario1_areasEstrategicas']  = $formulario1_areasEstrategicas;
                    $data['realizado_por']                  = User::find($formulario1->usuario_id);

                    $carrera_unidad_realizado               = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
                    $tipo_carreraUnidad_realizado           = $carrera_unidad_realizado->tipo_Carrera_UnidadaArea;
                    if($tipo_carreraUnidad_realizado->nombre=='CARRERAS'){
                        $data['tipo_carreraUnidad']         = 'Director. ';
                    }else if($tipo_carreraUnidad_realizado->nombre=='UNIDADES ADMINISTRATIVAS'){
                        $data['tipo_carreraUnidad']         = 'Jefe de . ';
                    }else{
                        $data['tipo_carreraUnidad']         = 'Jefe de . ';
                    }
                }
                return view('formulacion.formulaciones.primer_formulado.formulario1', $data);
            break;

            default:
                //para ver si existe la relacion
                $formulario1_Existe         = $configuracion_poa->formulario1()->where('unidadCarrera_id',Auth::user()->id_unidad_carrera)->get();
                if(count($formulario1_Existe)==0){

                    //$data['Rformulado_tipo'] = 2;
                    $configuracion_formuladoPOA =  Configuracion_formulado::where('gestiones_id', $id_gestiones)->orderBy('id','asc')->limit($configuracion_poa->formulado_id)->get();
                    $sacar_unaAnterior = $configuracion_formuladoPOA[count($configuracion_formuladoPOA)-2];
                    $formulario1_ant = $sacar_unaAnterior->formulario1()->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)->get();

                    $data['resultado'] = '0';
                    $formulario1_formulado2                     = new Formulario1;
                    $formulario1_formulado2->fecha              = date('Y-m-d');
                    $formulario1_formulado2->maxima_autoridad   = $formulario1_ant[0]->maxima_autoridad;
                    $formulario1_formulado2->gestion_id         = $id_gestiones;
                    $formulario1_formulado2->usuario_id         = Auth::user()->id;
                    $formulario1_formulado2->configFormulado_id = $id_formuladoConf;
                    $formulario1_formulado2->unidadCarrera_id   = Auth::user()->id_unidad_carrera;
                    $formulario1_formulado2->save();

                    //relacion anterio de muchos a muchos
                    $areasEstrategicasAnteriores = $formulario1_ant[0]->relacion_areasEstrategicas;

                    $formulario1_formulado2->relacion_areasEstrategicas()->sync($areasEstrategicasAnteriores->pluck('id'));

                    $data['tipo_error'] = 'Nota..!';
                    $data['mensaje'] = 'De un click en cualquiera de las burbujas';
                }else{
                    $data['resultado'] = '1';
                    $formulario1_es                         = $configuracion_poa->formulario1()->where('unidadCarrera_id',Auth::user()->id_unidad_carrera)->get();
                    $formulario1                            = Formulario1::find($formulario1_es[0]->id);
                    $formulario1_areasEstrategicas          = $formulario1->relacion_areasEstrategicas;
                    $data['formulario1']                    = $formulario1;
                    $data['formulario1_areasEstrategicas']  = $formulario1_areasEstrategicas;
                    $data['realizado_por']                  = User::find($formulario1->usuario_id);

                    $carrera_unidad_realizado               = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
                    $tipo_carreraUnidad_realizado           = $carrera_unidad_realizado->tipo_Carrera_UnidadaArea;
                    if($tipo_carreraUnidad_realizado->nombre=='CARRERAS'){
                        $data['tipo_carreraUnidad']         = 'Director. ';
                    }else if($tipo_carreraUnidad_realizado->nombre=='UNIDADES ADMINISTRATIVAS'){
                        $data['tipo_carreraUnidad']         = 'Jefe de . ';
                    }else{
                        $data['tipo_carreraUnidad']         = 'Jefe de . ';
                    }
                }
                return view('formulacion.formulaciones.segundo_formulado.formulario1',$data);
            break;
        }
    }

    //para guardar el primer formulado
    public function formulario1_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'maxima_autoridad'=>'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulario1                        = new Formulario1;
                $formulario1->fecha                 = date('Y-m-d');
                $formulario1->maxima_autoridad      = $request->maxima_autoridad;
                $formulario1->usuario_id            = Auth::user()->id;
                $formulario1->gestion_id            = $request->gestiones_id;
                $formulario1->configFormulado_id    = $request->configuracionFormulado_id;
                $formulario1->unidadCarrera_id      = Auth::user()->id_unidad_carrera;
                $formulario1->save();

                $formulario1->relacion_areasEstrategicas()->attach($request->areas_estrategicas1);
                $data=mensaje_array('success', 'Se guardo con exito el formulario');
            }
            return response()->json($data, 200);
        }
    }



    //para editar el formulario nº1
    public function formulario1_Editar(Request $request){
        if($request->ajax()){
            $formulario1                = Formulario1::find($request->id_formulario);
            $formulario1->relacion_areasEstrategicas;
            $data['formulario1_editar'] = $formulario1;
            $gestion = Gestion::find($request->id_gestion);
            $data['gestion'] = $gestion;
            $data['areas_estrategicas_editar'] = $gestion->relacion_areas_estrategicas;
            return view('formulacion.formulaciones.primer_formulado.operacionesFormulario.editarFormulario1', $data);
        }
    }
    //para guardar lo editado
    public function formulario1_EditarGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'maxima_autoridad_'=>'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                try {
                    $formulario1                    = Formulario1::find($request->id_formulario1);
                    $formulario1->maxima_autoridad  = $request->maxima_autoridad_;
                    //$formulario1->usuario_id = Auth::user()->id;
                    $formulario1->save();

                    $formulario1->relacion_areasEstrategicas()->sync($request->areas_estrategicasEditar);
                    if($formulario1->id){
                        $data=mensaje_array('success', 'Se editó con exito el formulario Nº 1');
                    }else{
                        $data=mensaje_array('error', 'Ocurrio un error al editar ');
                    }
                } catch (\Throwable $th) {
                    $data=mensaje_array('error', 'Ocurrio un error al editar ');
                }
            }
            return response()->json($data, 200);
        }
    }

    /**
     * PARA EL FORMULARIO Nº 2
     */
    public function formulario2($formulario1_id, $formuladoTipo_id){
        $id_formulario1                         = desencriptar($formulario1_id);
        $id_formuladoTipo                       = desencriptar($formuladoTipo_id);
        $formulario1                            = Formulario1::find($id_formulario1);
        $formulado_tipo                         = Formulado_tipo::find($id_formuladoTipo);
        $carrera_unidad                         = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
        $configuracion_formulado                = Configuracion_formulado::find($formulario1->configFormulado_id);
        $gestiones                              = Gestiones::find($formulario1->gestion_id);
        $formulario1_areasEstrategicas          = $formulario1->relacion_areasEstrategicas;
        $data['formulario1']                    = $formulario1;
        $data['formulado_tipo']                 = $formulado_tipo;
        $data['carrera_unidad']                 = $carrera_unidad;
        $data['gestiones']                      = $gestiones;
        $data['formulario1_areasEstrategicas']  = $formulario1_areasEstrategicas;
        $data['configuracion_formulado']        = $configuracion_formulado;
        $data['menu']                           = 13;
        return view('formulacion.formulaciones.primer_formulado.formulario2',$data);
    }

    //para seleccionar la articulacion PDES y PDU PEI
    public function form_areaEstrategicas($formulario1_id, $areaEstrategica_id){
        $id_formulario1                 = desencriptar($formulario1_id);
        $id_areaEstrategica             = desencriptar($areaEstrategica_id);
        $area_estrategica               = Areas_estrategicas::find($id_areaEstrategica);
        $formulario1                    = Formulario1::find($id_formulario1);
        $gestiones                      = Gestiones::find($formulario1->gestion_id);
        $carrera_unidad                 = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
        $configuracion_formulado        = Configuracion_formulado::find($formulario1->configFormulado_id);
        $gestion                        = Gestion::find($gestiones->id_gestion);
        $pdes                           = $gestion->relacion_pdes;
        $tipo_formulado                 = $configuracion_formulado->formulado_tipo;
        $data['configuracion_formulado']= $configuracion_formulado;
        $data['area_estrategica']       = $area_estrategica;
        $data['gestiones']              = $gestiones;
        $data['carrera_unidad']         = $carrera_unidad;
        $data['tipo_formulado']         = $tipo_formulado;
        $data['gestion']                = $gestion;
        $data['pdes']                   = $pdes;
        $data['formulario1']            = $formulario1;
        $data['menu']                   = 13;

        //para listar las politicas de desarrollo PDU
        $politica_desarrolloPDU = Politica_desarrollo::where('id_area_estrategica', $id_areaEstrategica)
                                                    ->where('id_tipo_plan', pdu_t())
                                                    ->get();
        $data['politica_desarrolloPDU'] = $politica_desarrolloPDU;

        //para listar las politicas de desarrollo PEI
        $politica_institucionalPEI = Politica_desarrollo::where('id_area_estrategica', $id_areaEstrategica)
                                                    ->where('id_tipo_plan', pei_t())
                                                    ->get();
        $data['politica_institucionalPEI'] = $politica_institucionalPEI;

        //indicador_estrategico
        /* $indicador_estrategico = $gestion->relacion_indicador()->where('estado','activo')->get();
        $data['indicador_estrategico']=$indicador_estrategico; */

        //reemplazamos con el indicador de la matriz de planificacion
        $gestion_idEsp = $gestion->id;
        $matriz_plani = Matriz_planificacion::with(['indicador_pei'=>function($query)use ($gestion_idEsp){
                    $query->where('id_gestion', $gestion_idEsp);
                    $query->where('estado', 'activo');
                }])
                ->where('id_area_estrategica', $id_areaEstrategica)
                ->orderBy('id_indicador','asc')
                ->get();
        $data['matriz_areaestrategica_indicador'] =  $matriz_plani;

        $data['listarForm2_AEstrategica'] = Formulario2::with('formulario1', 'indicador', 'objetivo_estrategico', 'politica_desarrollo_pdu', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional')
                ->where('areaestrategica_id',$id_areaEstrategica)
                ->where('gestion_id', $gestiones->id)
                ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                ->where('configFormulado_id',$formulario1->configFormulado_id)
                ->get();
        return view('formulacion.formulaciones.primer_formulado.operacionesFormulario.areaEstrategicaFormulario2',$data);
    }


    //para guardar el formulario N2
    public function guardar_form2(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo'                            => 'required',
                'politica_desarrollo_pdu'           => 'required',
                'objetivo_estrategico_pdu'          => 'required',
                'politica_institucional_pei'        => 'required',
                'objetivo_estrategico_sub'          => 'required',
                'objetivo_estrategico_institucional'=> 'required',
                'indicador_estrategico'             => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulario2                        = new Formulario2;
                $formulario2->codigo                = $request->codigo;
                $formulario2->formulario1_id        = $request->formulario1_id;
                $formulario2->configFormulado_id    = $request->configFormulado_id;
                $formulario2->indicador_id          = $request->indicador_estrategico;
                $formulario2->gestion_id            = $request->gestiones_id;
                $formulario2->areaestrategica_id    = $request->areaestrategica_id;
                $formulario2->unidadCarrera_id      = Auth::user()->id_unidad_carrera;
                $formulario2->save();

                //para guardar la politica de desarrollo PDU
                $formulario2->politica_desarrollo_pdu()->attach($request->politica_desarrollo_pdu);
                //para guardar el objetivo estrategico PDU
                $formulario2->objetivo_estrategico()->attach($request->objetivo_estrategico_pdu);
                //para guardar la politica de desarrollo PEI
                $formulario2->politica_desarrollo_pei()->attach($request->politica_institucional_pei);
                //para guardar objetivo de la SUB
                $formulario2->objetivo_estrategico_sub()->attach($request->objetivo_estrategico_sub);
                //para guardar la politica institiucional
                $formulario2->objetivo_institucional()->attach($request->objetivo_estrategico_institucional);

                if($formulario2->id){
                    $data = mensaje_array('success', 'Se guardo con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para validar si existe
    public function validar_existeIndicador(Request $request){
        if($request->ajax()){
            $formulario2_indicador = Formulario2::where('gestion_id', $request->id_ges)
                                                ->where('indicador_id', $request->id)
                                                ->where('configFormulado_id', $request->id_config)
                                                ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                                ->get();
            if(count($formulario2_indicador) > 0 ){
                $data = mensaje_array('success', 'Existe el registro, Seleccione uno diferente');
            }else{
                $data = mensaje_array('error', 'No existe');
            }
            return response()->json($data, 200);
        }
    }
    //para editar el formulario N2
    public function editar_form2(Request $request){
        if($request->ajax()){
            $formulario2_edi = Formulario2::with('politica_desarrollo_pdu', 'objetivo_estrategico','politica_desarrollo_pei','objetivo_estrategico_sub', 'objetivo_institucional','indicador')->find($request->id_form2);
            //para el objetivo estrategico del PDU
            $objetivo_estrategico_edi       = Objetivo_estrategico::where('id_politica_desarrollo', $formulario2_edi->politica_desarrollo_pdu[0]->id)->get();
            $objetivo_estrategico_sub_edi   = Objetivo_estrategico_sub::where('id_politica_desarrollo', $formulario2_edi->politica_desarrollo_pei[0]->id)->get();
            $objetivo_institucional_edi     = Objetivo_institucional::where('id_objetivo_estrategico_sub', $formulario2_edi->objetivo_estrategico_sub[0]->id)->get();
            if($formulario2_edi){
                $data=array(
                    'tipo'                              => 'success',
                    'formulario2_edi'                   => $formulario2_edi,
                    'objetivo_estrategico_edi'          => $objetivo_estrategico_edi,
                    'objetivo_estrategico_sub_edi'      => $objetivo_estrategico_sub_edi,
                    'objetivo_institucional_edi'        => $objetivo_institucional_edi,
                );
            }else{
                $data=mensaje_array('error', 'No existe los datos a consultar');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function editar_form2guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo_'                            => 'required',
                'politica_desarrollo_pdu_'           => 'required',
                'objetivo_estrategico_pdu_'          => 'required',
                'politica_institucional_pei_'        => 'required',
                'objetivo_estrategico_sub_'          => 'required',
                'objetivo_estrategico_institucional_'=> 'required',
                'indicador_estrategico_'             => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulario2                    = Formulario2::find($request->formulario2Edi_id);
                $formulario2->codigo            = $request->codigo_;
                $formulario2->indicador_id      = $request->indicador_estrategico_;
                $formulario2->save();
                //para guardar la politica de desarrollo PDU
                $formulario2->politica_desarrollo_pdu()->sync($request->politica_desarrollo_pdu_);
                //para guardar el objetivo estrategico PDU
                $formulario2->objetivo_estrategico()->sync($request->objetivo_estrategico_pdu_);
                //para guardar la politica de desarrollo PEI
                $formulario2->politica_desarrollo_pei()->sync($request->politica_institucional_pei_);
                //para guardar objetivo de la SUB
                $formulario2->objetivo_estrategico_sub()->sync($request->objetivo_estrategico_sub_);
                //para guardar la politica institiucional
                $formulario2->objetivo_institucional()->sync($request->objetivo_estrategico_institucional_);
                if($formulario2->id){
                    $data = mensaje_array('success', 'Se editó con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al editar');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para validar el indicador si puede estar en otro o no
    public function validar_IndicadorExiste(Request $request){
        if($request->ajax()){
            $formulario2 = Formulario2::where('indicador_id', $request->id)
                                            ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                            ->find($request->id_form2);
            if($formulario2){
                $data=mensaje_array('success', 'continue');
            }else{
                $formulario2_indicador = Formulario2::where('gestion_id', $request->id_ges)
                                                ->where('indicador_id', $request->id)
                                                ->where('configFormulado_id', $request->id_config)
                                                ->where('id','!=',$request->id_form2 )
                                                ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                                ->get();
                if(count($formulario2_indicador) > 0 ){
                    $data = mensaje_array('error', 'Existe el registro, Seleccione uno diferente');
                }else{
                    $data = mensaje_array('success', 'continue');
                }
            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN DEL FORMULARIO Nº 2
     */

    /**
        * INICIO DEL FORMULARIO Nº4
    */
    public function formulario4($formulario1_id, $formuladoTipo_id){
        $id_formulario1                         = desencriptar($formulario1_id);
        $id_formuladoTipo                       = desencriptar($formuladoTipo_id);
        $formulario1                            = Formulario1::find($id_formulario1);
        $formulado_tipo                         = Formulado_tipo::find($id_formuladoTipo);
        $carrera_unidad                         = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
        $configuracion_formulado                = Configuracion_formulado::find($formulario1->configFormulado_id);
        $gestiones                              = Gestiones::find($formulario1->gestion_id);
        $formulario1_areasEstrategicas          = $formulario1->relacion_areasEstrategicas;
        $data['formulario1']                    = $formulario1;
        $data['formulado_tipo']                 = $formulado_tipo;
        $data['carrera_unidad']                 = $carrera_unidad;
        $data['gestiones']                      = $gestiones;
        $data['formulario1_areasEstrategicas']  = $formulario1_areasEstrategicas;
        $data['configuracion_formulado']        = $configuracion_formulado;
        $data['menu']                           = 13;
        return view('formulacion.formulaciones.primer_formulado.formulario4', $data);
    }
    //para ingresar a las areas estrategicas
    public function form4AreasEstrategicas($formulario1_id, $areaEstrategica_id){
        $id_formulario1 = desencriptar($formulario1_id);
        $id_areaEstrategica = desencriptar($areaEstrategica_id);

        $area_estrategica               = Areas_estrategicas::find($id_areaEstrategica);
        $formulario1                    = Formulario1::find($id_formulario1);
        $gestiones                      = Gestiones::find($formulario1->gestion_id);
        $carrera_unidad                 = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
        $configuracion_formulado        = Configuracion_formulado::find($formulario1->configFormulado_id);
        $gestion                        = Gestion::find($gestiones->id_gestion);
        $pdes                           = $gestion->relacion_pdes;
        $tipo_formulado                 = $configuracion_formulado->formulado_tipo;
        $data['configuracion_formulado']= $configuracion_formulado;
        $data['area_estrategica']       = $area_estrategica;
        $data['gestiones']              = $gestiones;
        $data['carrera_unidad']         = $carrera_unidad;
        $data['tipo_formulado']         = $tipo_formulado;
        $data['gestion']                = $gestion;
        $data['pdes']                   = $pdes;
        $data['formulario1']            = $formulario1;
        $data['menu']                   = 13;

        $data['tipo']                   = Tipo::get();
        $data['categoria']              = Categoria::get();
        $data['bien_sevicio']           = BienNServicio::get();
        $data['unidades']               = UnidadCarreraArea::where('id_tipo_carrera', unidades_adm())->get();

        $formulario2 = Formulario2::where('formulario1_id', $id_formulario1)
                                    ->where('gestion_id', $gestiones->id)
                                    ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                    ->where('areaestrategica_id', $id_areaEstrategica)
                                    ->where('configFormulado_id', $configuracion_formulado->id)
                                    ->orderBy('indicador_id','asc')
                                    ->get();
        $data['formulario2'] = $formulario2;
        $confg_fomula = $configuracion_formulado->id;
        $ges_id = $gestiones->id;


        /* $formulario4_listar = Formulario4::with(['tipo','categoria','bien_servicio','unidad_responsable','asignacion_monto_f4','formulario2'=>function($query) use ($id_areaEstrategica){
                $query->with('indicador','politica_desarrollo_pdu','objetivo_estrategico','politica_desarrollo_pei', 'objetivo_estrategico_sub','objetivo_institucional');
                $query->where('areaestrategica_id', $id_areaEstrategica);
            }])
            ->where('configFormulado_id', $confg_fomula)
            ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->where('gestion_id', $ges_id)
            ->get(); */

        $formulario4_lis = Formulario4::with(['tipo','categoria','bien_servicio','unidad_responsable','asignacion_monto_f4','formulario2'=>function($query) use ($id_areaEstrategica){
                $query->with('indicador','politica_desarrollo_pdu','objetivo_estrategico','politica_desarrollo_pei', 'objetivo_estrategico_sub','objetivo_institucional');
                $query->where('areaestrategica_id', $id_areaEstrategica);
            }])
                                            ->where('configFormulado_id', $confg_fomula)
                                            ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                            ->where('gestion_id',  $ges_id)
                                            ->where('areaestrategica_id',$id_areaEstrategica)
                                            ->get();
        //dd($formulario4_lis);
        $data['formulario4_listar'] = $formulario4_lis;
        return view('formulacion.formulaciones.primer_formulado.operacionesFormulario.areaEstrategicaFormulario4', $data);
    }

    //para validar que solo exista un registro en la tabla de form4 del form2
    public function validarf4f2(Request $request){
        if($request->ajax()){
            $existe_yaelform2 = Formulario4::where('formulario2_id', $request->id_formulario2)
                                            ->where('configFormulado_id', $request->id_configf)
                                            ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                            ->where('gestion_id', $request->id_gestiones)
                                            ->get();
            $formuario2 = Formulario2::with('politica_desarrollo_pei','objetivo_estrategico_sub','objetivo_institucional')->find($request->id_formulario2);
            if(count($existe_yaelform2)>0){
                $data = mensaje_array('error', 'Porfavor seleccione un indicador diferente!');
                $data = array(
                    'tipo'      => 'error',
                    'mensaje'   => 'Porfavor seleccione un indicador diferente!',
                    'form2_rel' => $formuario2
                );
            }else{
                $data = array(
                    'tipo'      => 'success',
                    'mensaje'   => 'continue',
                    'form2_rel' => $formuario2
                );
            }
            return  response()->json($data, 200);
        }
    }
    //para guardar el formulario 4
    public function guardar_formulario4(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo'                => 'required',
                'indicador_formulario2' => 'required',
                'tipo'                  => 'required',
                'categoria'             => 'required',
                'bien_servicio'         => 'required',
                'primer_semestre'       => 'required',
                'segundo_semestre'      => 'required',
                'meta_anual'            => 'required',
                'unidades_responsable'  => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulario4                        = new Formulario4;
                $formulario4->codigo                = $request->codigo;
                $formulario4->formulario2_id        = $request->indicador_formulario2;
                $formulario4->configFormulado_id    = $request->configFormulado;
                $formulario4->unidadCarrera_id      = Auth::user()->id_unidad_carrera;
                $formulario4->areaestrategica_id    = $request->area_estrategica;
                $formulario4->gestion_id            = $request->gestiones_id;
                $formulario4->tipo_id               = $request->tipo;
                $formulario4->categoria_id          = $request->categoria;
                $formulario4->bnservicio_id         = $request->bien_servicio;
                $formulario4->primer_semestre       = $request->primer_semestre;
                $formulario4->segundo_semestre      = $request->segundo_semestre;
                $formulario4->meta_anual            = $request->meta_anual;
                $formulario4->save();

                $formulario4->unidad_responsable()->attach($request->unidades_responsable);
                if($formulario4->id){
                    $data = mensaje_array('success', 'Se inserto con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al insertar');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar el formulario 4
    public function editarform4(Request $request){
        if($request->ajax()){
            $formulario4 = Formulario4::with(['unidad_responsable','formulario2'=>function($query){
                $query->with('indicador','politica_desarrollo_pdu','objetivo_estrategico','politica_desarrollo_pei', 'objetivo_estrategico_sub','objetivo_institucional');
            }])
            ->find($request->id);
            if($formulario4){
                $data = mensaje_array('success', $formulario4);
            }else{
                $data = mensaje_array('error', 'No se pudo encontrar el registro');
            }
            return response()->json($data, 200);
        }
    }

    //para validar cuando esta editado
    public function validarf4f2edi(Request $request){
        $formulario4 = Formulario4::where('formulario2_id', $request->id_form2)
                                    ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                    ->find($request->id_form4);
        //para las relaciones del formulario2
        $formuario2 = Formulario2::with('politica_desarrollo_pei','objetivo_estrategico_sub','objetivo_institucional')->find($request->id_form2);
        if($formulario4){
            $data = array(
                'tipo'=>'success',
                'mensaje'=>'continue',
                'formulario2f4'=>$formuario2
            );
        }else{
            $formulario4_formulario2 = Formulario4::where('gestion_id', $request->id_gestiones)
                                                ->where('formulario2_id', $request->id_form2)
                                                ->where('configFormulado_id', $request->id_configf)
                                                ->where('id', '!=', $request->id_form4)
                                                ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                                                ->get();
            if(count($formulario4_formulario2) > 0 ){
                $data = array(
                    'tipo'=>'error',
                    'mensaje'=>'Existe el registro, Seleccione uno diferente',
                    'formulario2f4'=>$formuario2
                );
            }else{
                $data = array(
                    'tipo'=>'success',
                    'mensaje'=>'continue',
                    'formulario2f4'=>$formuario2
                );
            }
        }
        return response()->json($data, 200);
    }
    //para guardar el formulario 4 editado
    public function editarform4_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'codigo_'                => 'required',
                'indicador_formulario2_' => 'required',
                'tipo_'                  => 'required',
                'categoria_'             => 'required',
                'bien_servicio_'         => 'required',
                'primer_semestre_'       => 'required',
                'segundo_semestre_'      => 'required',
                'meta_anual_'            => 'required',
                'unidades_responsable_'  => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulario4                        = Formulario4::find($request->formulario4_id);
                $formulario4->codigo                = $request->codigo_;
                $formulario4->formulario2_id        = $request->indicador_formulario2_;
                $formulario4->unidadCarrera_id      = Auth::user()->id_unidad_carrera;
                $formulario4->tipo_id               = $request->tipo_;
                $formulario4->categoria_id          = $request->categoria_;
                $formulario4->bnservicio_id         = $request->bien_servicio_;
                $formulario4->primer_semestre       = $request->primer_semestre_;
                $formulario4->segundo_semestre      = $request->segundo_semestre_;
                $formulario4->meta_anual            = $request->meta_anual_;
                $formulario4->save();

                $formulario4->unidad_responsable()->sync($request->unidades_responsable_);
                if($formulario4->id){
                    $data = mensaje_array('success', 'Se edito con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al editar');
                }
            }
            return response()->json($data, 200);
        }
    }
    /**
        * FIN DE FORMULARIO Nº4
    */


}
