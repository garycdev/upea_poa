<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Gestion;
use App\Models\Gestiones;
use App\Models\Areas_estrategicas;

use Illuminate\Support\Facades\Validator;


class Controlador_Gestion extends Controller{
    //para ir a la ruta de gestión
    public function gestion(){
        $data['menu']       = '5';
        $data['gestion']    = Gestion::orderBy('id', 'desc')->get();
        return view('administrador.gestion.gestion',$data);
    }

    //para listar lo que es la gestion
    public function gestion_listar(){
        $gestion = Gestion::orderBy('id', 'desc')->get();
        if($gestion){
            $data=array(
                'tipo'=>'success',
                'mensaje'=>$gestion,
            );
        }else{
            $data=array(
                'tipo'=>'error',
                'mensaje'=>'No existe registros'
            );
        }
        return response()->json($data, 200);
    }

    //para guardar la gestion
    public function gestion_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'gestion_inicial'   => 'required|unique:rl_gestion,inicio_gestion',
                'gestion_final'     => 'required|unique:rl_gestion,fin_gestion'
            ]);

            if($validar->fails()){
                $data=array(
                    'tipo'=>'errores',
                    'mensaje'=>$validar->errors()
                );
            }else{
                $gestion                 = new Gestion;
                $gestion->inicio_gestion = $request->gestion_inicial;
                $gestion->fin_gestion    = $request->gestion_final;
                $gestion->estado         = 'inactivo';
                if($gestion->save()){
                    for ($i=$request->gestion_inicial; $i <= $request->gestion_final; $i++) {
                        $gestiones              = new Gestiones;
                        $gestiones->gestion     = $i;
                        $gestiones->estado      = 'inactivo';
                        $gestiones->id_gestion  = $gestion->id;
                        $gestiones->save();
                    }
                    $data=array(
                        'tipo'   =>'success',
                        'mensaje'=>'Se inserto con éxito la nueva gestión!'
                    );
                }else{
                    $data=array(
                        'tipo'   =>'error',
                        'mensaje'=>'Ocurrio un error al insertar!'
                    );
                }
            }
            return response()->json($data, 200);
        }
    }

    //para eliminar una gestión
    public function gestion_eliminar(Request $request){
        try {
            $gestion = Gestion::find($request->id);
            if($gestion->delete()){
                $data = mensaje_array('success','Se elimino con éxito!');
            }else{
                $data = mensaje_array('error','Ocrrio un error al eliminar!');
            }
        } catch (\Throwable $th) {
            $data = mensaje_array('error','Ocrrio un error al eliminar!');
        }
        return response()->json($data, 200);
    }
    //para editar gestion
    public function gestion_editar(Request $request){
        if($request->ajax()){
            $gestion = Gestion::find($request->id);
            if($gestion){
                $data = mensaje_array('success',$gestion);
            }else{
                $data = mensaje_array('error','No se encontro el registro!');
            }
            return response()->json($data, 200);
        }
    }

    //para guardar lo editado
    public function gestion_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'gestion_inicial_e' => 'required|unique:rl_gestion,inicio_gestion,'.$request->id_gestion_edi,
                'gestion_final_e'   => 'required|unique:rl_gestion,fin_gestion,'.$request->id_gestion_edi
            ]);

            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{

                $gestiones = Gestiones::where('id_gestion', $request->id_gestion_edi)->get();
                foreach($gestiones as $lis){
                    $lis->delete();
                }

                $gestion                 = Gestion::find($request->id_gestion_edi);
                $gestion->inicio_gestion = $request->gestion_inicial_e;
                $gestion->fin_gestion    = $request->gestion_final_e;
                $gestion->estado         = 'activo';
                if($gestion->save()){
                    for ($i=$request->gestion_inicial_e; $i <= $request->gestion_final_e; $i++) {
                        $gestiones_nuevo              = new Gestiones;
                        $gestiones_nuevo->gestion     = $i;
                        $gestiones_nuevo->estado      = 'activo';
                        $gestiones_nuevo->id_gestion  = $gestion->id;
                        $gestiones_nuevo->save();
                    }
                    $data = mensaje_array('success','Se edito con exito la gestión!');
                }else{
                    $data = mensaje_array('error','Ocurrio un error al editar!');
                }
            }
            return response()->json($data, 200);
        }
    }


    //para cambiar el estado
    public function gestion_estado(Request $request){
        if($request->ajax()){
            $gestion            = Gestion::find($request->id);
            $estado             = ($gestion->estado=='activo') ? 'inactivo':'activo';
            $gestion->estado    = $estado;
            if($gestion->save()){
                $data = mensaje_array('success','Se cambio el estado con éxito!');
            }else{
                $data = mensaje_array('error','Ocurrio un error al momento de cambiar el estado!');
            }
            return response()->json($data, 200);
        }
    }

    /**
     * Gestiones
     */

    //listar las gestions
    public function gestiones_listar(Request $request){
        $gestiones = Gestiones::where('id_gestion', $request->id)->get();
        if($gestiones){
            $data = mensaje_array('success',$gestiones);
        }else{
            $data = mensaje_array('error','No hay registros');
        }
        return response()->json($data, 200);
    }
    //cambiar estado de las gestiones
    public function gestiones_estado(Request $request){
        if($request->ajax()){
            $gestiones = Gestiones::find($request->id);
            $estado = ($gestiones->estado=='activo')?'inactivo':'activo';
            $gestiones->estado = $estado;
            if($gestiones->save()){
                $data=array(
                    'tipo'=>'success',
                    'mensaje'=>'Se cambio el estado con éxito!',
                    'id_rec'=>$gestiones->id_gestion
                );
            }else{
                $data=array(
                    'tipo'=>'error',
                    'mensaje'=>'Ocurrio un error!'
                );
            }
            return response()->json($data, 200);
        }
    }

    /**
     * AREAS ESTRATEGICAS
    */
    public function listar_areas_estrategicas(Request $request){
        if($request->ajax()){
            $areas_estrategicas = Gestion::with('relacion_areas_estrategicas')->find($request->id);

            if($areas_estrategicas){
                $data=array(
                    'tipo'      => 'success',
                    'mensaje'   => $areas_estrategicas,
                    'id_ges'    => $request->id
                );
            }else{
                $data = mensaje_array('error','no hay registro');
            }
            return response()->json($data, 200);
        }
    }

    public function areas_estrategicas_crear(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'codigo'        => 'required',
                'descripcion'   => 'required'
            ]);

            if($validar->fails()){
                $data=array(
                    'tipo'=>'errores',
                    'mensaje'=>$validar->errors()
                );
            }else{
                $id = $request->id_area_estrategica;
                if($id){
                    $areas_estrategicas                             = Areas_estrategicas::find($id);
                    $areas_estrategicas->codigo_areas_estrategicas  = $request->codigo;
                    $areas_estrategicas->descripcion                = $request->descripcion;
                    $areas_estrategicas->id_usuario                 = auth()->id();
                    if($areas_estrategicas->save()){
                        $data=array(
                            'tipo'      => 'success',
                            'mensaje'   => 'Se edito con éxito!',
                            'id_aec'    => $areas_estrategicas->id_gestion,
                        );
                    }else{
                        $data=array(
                            'tipo'      => 'error',
                            'mensaje'   => 'Ocurrio un error al guardar'
                        );
                    }
                }else{
                    $areas_estrategicas                             = new Areas_estrategicas;
                    $areas_estrategicas->codigo_areas_estrategicas  = $request->codigo;
                    $areas_estrategicas->descripcion                = $request->descripcion;
                    $areas_estrategicas->estado                     = 'activo';
                    $areas_estrategicas->id_gestion                 = $request->id_gestion;
                    $areas_estrategicas->id_usuario                 = auth()->id();
                    if($areas_estrategicas->save()){
                        $data=array(
                            'tipo'      => 'success',
                            'mensaje'   => 'Se guardo con éxito!',
                            'id_aec'    => $request->id_gestion,
                        );
                    }else{
                        $data = mensaje_array('error','Ocurrio un error al guardar');
                    }
                }
            }
            return response()->json($data, 200);
        }
    }

    //para cambiar el estad
    public function areas_estrategicas_estado(Request $request){
        if($request->ajax()){
            $areas_estrategicas             = Areas_estrategicas::find($request->id);
            $estado                         = ($areas_estrategicas->estado=='activo') ? 'inactivo':'activo';
            $areas_estrategicas->estado     = $estado;
            if($areas_estrategicas->save()){
                $data=array(
                    'tipo'      => 'success',
                    'mensaje'   => 'Se cambio el estado con éxito!',
                    'ges_id'    => $areas_estrategicas->id_gestion,
                );
            }else{
                $data = mensaje_array('error','Ocurrio un error al cambiar el estado!!');
            }
            return response()->json($data, 200);
        }
    }

    //para eliminnar areas estrategicas
    public function areas_estrategicas_eliminar(Request $request){
        if($request->ajax()){
            try {
                $areas_estrategicas = Areas_estrategicas::find($request->id);
                if($areas_estrategicas->delete()){
                    $data=array(
                        'tipo'      => 'success',
                        'mensaje'   => 'Se eliminó con éxito!',
                        'id_ges'    => $request->id_gestion
                    );
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al eliminar!');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error', 'Ocurrio un problema al eliminar!');
            }
            return response()->json($data, 200);
        }
    }

    //editar
    public function areas_estrategicas_editar(Request $request){
        if($request->ajax()){
            $areas_estrategicas = Areas_estrategicas::find($request->id);
            if($areas_estrategicas){
                $data = mensaje_array('success', $areas_estrategicas);
            }else{
                $data = mensaje_array('error', 'No se encontrol los datos');
            }
            return response()->json($data, 200);
        }
    }
    /**
     * AREAS ESTRATEGICAS
    */

    /**
     * PARA LA PARTE DE DETALLES
     */
    public function detalles(Request $request){
        $data['id_ges'] = $request->id;
        return view('administrador.gestion.detalles',$data);
    }

    public function pdes($id){
        echo $id;
    }
    /**
     * FIN PARA LA PARTE DE DETALLES
     */
}
