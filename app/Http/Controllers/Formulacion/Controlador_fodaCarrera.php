<?php
namespace App\Http\Controllers\Formulacion;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Gestiones;
use App\Models\Pei\Tipo_foda;
use App\Models\Poa\Foda_carrerasUnidad;
use App\Models\Poa\Formulario1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_fodaCarrera extends Controller
{
    //para listar foda de las carreras y unidades administrativas
    public function listado_fodac($id_gestion, $id_formulario1)
    {
        $gestiones_id   = desencriptar($id_gestion);
        $formulario1_id = desencriptar($id_formulario1);
        $gestiones      = Gestiones::find($gestiones_id);
        $ges_anterior   = $gestiones->gestion - 1;
        //$gestion_anterior = Gestiones::where('gestion','like', $ges_anterior)->get();
        $formulario1                     = Formulario1::find($formulario1_id);
        $configuracion_formulado         = Configuracion_formulado::find($formulario1->configFormulado_id);
        $data['carrera']                 = UnidadCarreraArea::find(Auth::user()->id_unidad_carrera);
        $data['menu']                    = 13;
        $data['gestiones']               = $gestiones;
        $data['tipo_foda']               = Tipo_foda::orderBy('id', 'asc')->get();
        $data['configuracion_formulado'] = $configuracion_formulado;
        $data['formulario1']             = $formulario1;
        //preguntamos si existe la gestion anterior
        //dd($gestion_anterior);
        /* if(count($gestion_anterior)>0){
            $foda_carraraGestionActual = Foda_carrerasUnidad::where('gestion_id',$id_gestion)
                                                        ->where('UnidadCarrera_id', Auth::user()->id_unidad_carrera)
                                                        ->get();
            if(count($foda_carraraGestionActual)==0){
                $foda_carrera_Unidad = Foda_carrerasUnidad::where('gestion_id', $gestion_anterior[0]->id)
                            ->where('UnidadCarrera_id', Auth::user()->id_unidad_carrera)
                            ->get();
                if(count($foda_carrera_Unidad)==0){
                    foreach($foda_carrera_Unidad as $lis){
                        $foda_cpNuevoReg                    = new Foda_carrerasUnidad;
                        $foda_cpNuevoReg->descripcion       = $lis->descripcion;
                        $foda_cpNuevoReg->tipo_foda_id      = $lis->tipo_foda_id;
                        $foda_cpNuevoReg->gestion_id        = $gestiones_id;
                        $foda_cpNuevoReg->unidadCarrera_id  = Auth::user()->id_unidad_carrera;
                        $foda_cpNuevoReg->usuario_id        = Auth::user()->id;
                        $foda_cpNuevoReg->save();
                    }
                    $data['resultado']='dato_llenar';
                }else{
                    $data['resultado']='vacio';
                }
            }else{
                $data['resultado']='vacio';
            }
        }else{
            $data['resultado']='vacio';
        } */
        return view('formulacion.formulaciones.foda_carreras.foda', $data);
    }

    //para listar foda de las carreras
    public function listarFoda_c(Request $request)
    {
        if ($request->ajax()) {
            $foda_carrerasUnidadListar = Foda_carrerasUnidad::where('gestion_id', $request->id_gestiones)
                ->where('tipo_foda_id', $request->tipo_foda)
                ->where('UnidadCarrera_id', Auth::user()->id_unidad_carrera)
                ->get();
            if ($foda_carrerasUnidadListar) {
                $data = mensaje_array('success', $foda_carrerasUnidadListar);
            } else {
                $data = mensaje_array('error', 'No hay');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el foda
    public function guardarFoda_c(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'tipo_foda' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $descripcion_repetidor = json_decode(json_encode($request->repetir_foda));
                if ($descripcion_repetidor != null) {
                    $contar_array = count($descripcion_repetidor);
                    if ($contar_array >= minimo_agregar()) {
                        if ($contar_array <= maximo_agregar()) {
                            foreach ($descripcion_repetidor as $listar) {
                                if ($listar->descripcion != '') {
                                    $guardar_foda                   = new Foda_carrerasUnidad;
                                    $guardar_foda->descripcion      = $listar->descripcion;
                                    $guardar_foda->tipo_foda_id     = $request->tipo_foda;
                                    $guardar_foda->gestion_id       = $request->gestion_id;
                                    $guardar_foda->estado           = 'activo';
                                    $guardar_foda->unidadCarrera_id = Auth::user()->id_unidad_carrera;
                                    $guardar_foda->usuario_id       = Auth::user()->id;
                                    $guardar_foda->save();
                                }
                                $data = mensaje_array('success', 'Se guardo con exito');
                            }
                        } else {
                            $data = mensaje_array('error', 'Solo puede guardar ' . maximo_agregar() . ' de registros');
                        }
                    } else {
                        $data = mensaje_array('error', 'Debe contener al menos' . minimo_agregar() . ' registro');
                    }
                } else {
                    $data = mensaje_array('error', 'No se encontro ningun registro');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar el foda
    public function editarFoda_c(Request $request)
    {
        if ($request->ajax()) {
            $foda_unidadCarrera = Foda_carrerasUnidad::find($request->id);
            $tipo_fodaEdi       = $foda_unidadCarrera->tipo_foda;
            if ($foda_unidadCarrera->id) {
                $data = [
                    'tipo'               => 'success',
                    'foda_unidadCarrera' => $foda_unidadCarrera,
                    'tipo_foda'          => $tipo_fodaEdi,
                ];
            } else {
                $data = mensaje_array('error', 'No se econtro el registro');
            }
            return response()->json($data);
        }
    }
    //para guardar lo editado
    public function editarFoda_guardar(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'descripcion_' => 'required',
        ]);
        if ($validar->fails()) {
            $data = mensaje_array('errores', $validar->errors());
        } else {
            $guardar_foda                   = Foda_carrerasUnidad::find($request->id_fodaEdi);
            $guardar_foda->descripcion      = $request->descripcion_;
            $guardar_foda->unidadCarrera_id = Auth::user()->id_unidad_carrera;
            $guardar_foda->usuario_id       = Auth::user()->id;
            $guardar_foda->save();
            if ($guardar_foda->id) {
                $data = mensaje_array('success', 'Se edito con éxito');
            } else {
                $data = mensaje_array('error', 'Ocurrio un error al editar');
            }
        }
        return response()->json($data, 200);
    }
}
