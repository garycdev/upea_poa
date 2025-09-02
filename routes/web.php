<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Usuario_controlador;
use App\Http\Controllers\Usuario\Administracion_usuario;
use App\Models\User;

//para la gestion
use App\Http\Controllers\Administracion\Controlador_Gestion;
//para PDES
use App\Http\Controllers\Administracion\Controlador_Pdes;
//para AREAS ESTRATEGICAS
use App\Http\Controllers\Administracion\Controlador_Areas_estrategicas;
use App\Http\Controllers\Administracion\Controlador_asignarFinanciamiento;
use App\Http\Controllers\Administracion\Controlador_clasificador;
use App\Http\Controllers\Administracion\Controlador_Configuracion;
use App\Http\Controllers\Administracion\Controlador_Foda;
use App\Http\Controllers\Administracion\Controlador_indicador;
use App\Http\Controllers\Administracion\Controlador_Pdu;
use App\Http\Controllers\Administracion\Controlador_Pei;
//para PARTE DE LAS CARRERAS UNIDADES ADMINISTRATIVAS
use App\Http\Controllers\Administracion\Controlador_carrera;
use App\Http\Controllers\Administracion\Controlador_formulado;
use App\Http\Controllers\Formulacion\Controlador_fodaCarrera;
use App\Http\Controllers\Formulacion\Controlador_formulacion;
use App\Http\Controllers\Formulacion\Controlador_formulario2;
use App\Http\Controllers\Administracion\Controlador_reportesPDF;
use App\Http\Controllers\Formulacion\Controlador_formulario5;

    Route::prefix('/')->middleware(['no_autenticados'])->group(function () {
        Route::get('/', function () {
            return view('login');
        });
        Route::get('login', function () {
            return view('login');
        })->name('login');

        //PARA LAS RUTAS AUTENTICAR USUARIO
        Route::post('autenticar', [Usuario_controlador::class, 'validar_usuario'])->name('ingresar');
        Route::get('captcha', [Usuario_controlador::class, 'generateCaptchaImage'])->name('captcha');
    });

    Route::prefix('/poa')->middleware(['autenticados'])->group(function(){

        /**
         * USUARIO CONTROLADOR salir e inicio
         */
        Route::controller(Usuario_controlador::class)->group(function(){
            Route::get('/', 'inicio')->name('inicio');
            Route::get('inicio', 'inicio')->name('inicio');
            Route::post('cerrar_session', 'cerrar_session')->name('salir');

            Route::post('ver_carrerasunidades','ver_carrerasunidades')->name('ver_carreras_unidades');
            Route::post('ver_formularios_can','ver_formularios_can')->name('ver_formularios_can');
        });

        /**
         * ADMINISTRACION DE USUARIO
         */
        Route::controller(Administracion_usuario::class)->group(function(){
            //USUARIOS
            Route::get('usuarios', 'usuarios')->name('adm_usuario');
            Route::post('validar_ci', 'validar_ci')->name('adm_validar_ci');
            Route::post('usuario_guardar', 'usuario_guardar')->name('adm_guardar_usuario');
            Route::post('usuario_eliminar', 'usuario_eliminar')->name('adm_eliminar_usuario');
            Route::post('usuario_reset', 'usuario_reset')->name('adm_reset_usuario');
            Route::post('usuario_reset_guardar', 'usuario_reset_guardar')->name('adm_reset_usuario_guardar');
            Route::post('usuario_editar', 'usuario_editar')->name('adm_editar_usuario');
            Route::post('usuario_editar_guardar', 'usuario_editar_guardar')->name('adm_editar_usuario_guardar');
            Route::post('usuario_estado', 'usuario_estado')->name('adm_usuario_estado');

            //para la parte de asignar carrera o unidad administrativa
            Route::post('usuario_cua','usuario_cua')->name('adm_usuario_cua');
            Route::post('usuario_listar_cua','usuario_listar_cua')->name('adm_usuario_listar_cua');

            //ROLES
            Route::get('roles','roles')->name('adm_rol');
            Route::post('rol_guardar','rol_guardar')->name('adm_guardar_rol');
            Route::post('rol_eliminar','rol_eliminar')->name('adm_eliminar_rol');
            Route::post('rol_editar','rol_editar')->name('adm_editar_rol');
            Route::post('rol_editar_guardar','rol_editar_guardar')->name('adm_editar_guardar_rol');
            //PERMISOS
            Route::get('permisos', 'permisos')->name('adm_permiso');
            Route::post('crear_permisos', 'crear_permisos')->name('adm_crear_permiso');
            Route::post('listar_permisos', 'listar_permisos')->name('adm_listar_permiso');
            Route::post('eliminar_permisos', 'eliminar_permisos')->name('adm_eliminar_permiso');
            Route::post('editar_permiso', 'editar_permiso')->name('adm_editar_permiso');
            Route::post('guardar_edi_permiso', 'guardar_edi_permiso')->name('adm_guardar_edi_permiso');
            //PERFIL
            Route::get('perfil', 'perfil')->name('adm_perfil');
            Route::post('perfil_guardar', 'perfil_guardar')->name('adm_perfil_guardar');
            Route::post('perfil_password', 'perfil_password')->name('adm_perfil_password');
            Route::post('perfil_imagen', 'perfil_imagen')->name('adm_perfil_imagen');
        });
        /**
         * FIN DE ADMINISTRACION DE USUARIO
         */

        /**
         * PARA LA PARTE DE LA GESTIÓN
         */
        Route::controller(Controlador_Gestion::class)->group(function(){
            //administrar gestión
            Route::get('gestion', 'gestion')->name('adm_gestion');
            Route::post('gestion_listar', 'gestion_listar')->name('adm_gestion_listar');
            Route::post('gestion_guardar', 'gestion_guardar')->name('adm_gestion_guardar');
            Route::post('gestion_eliminar', 'gestion_eliminar')->name('adm_gestion_eliminar');
            Route::post('gestion_editar', 'gestion_editar')->name('adm_gestion_editar');
            Route::post('gestion_estado', 'gestion_estado')->name('adm_gestion_estado');
            Route::post('gestion_editar_guardar', 'gestion_editar_guardar')->name('adm_gestion_editar_guardar');

            //administrar gestiones
            Route::post('gestiones_listar', 'gestiones_listar')->name('adm_gestiones_listar');
            Route::post('gestiones_estado', 'gestiones_estado')->name('adm_gestiones_estado');

            //administrar areas estrategicas
            Route::post('listar_areas_estrategicas','listar_areas_estrategicas')->name('adm_listar_areas_estrategicas');
            Route::post('areas_estrategicas_crear','areas_estrategicas_crear')->name('adm_areas_estrategicas_crear');
            Route::post('areas_estrategicas_estado','areas_estrategicas_estado')->name('adm_areas_estrategicas_estado');
            Route::post('areas_estrategicas_eliminar','areas_estrategicas_eliminar')->name('adm_areas_estrategicas_eliminar');
            Route::post('areas_estrategicas_editar','areas_estrategicas_editar')->name('adm_areas_estrategicas_editar');

            //para la parte de detalles
            Route::post('detalles', 'detalles')->name('adm_detalles');
        });
        /**
         * FIN DE LA PARTE DE GESTIÓN
         */

        /**
         * PLAN DE DESARROLLO ECONOMICO Y SOCIAL
        */
        Route::controller(Controlador_Pdes::class)->group(function(){
            Route::post('pdes_detalle','pdes_detalle')->name('adm_pdes_detalle');
            Route::post('pdes_guardar', 'pdes_guardar')->name('adm_pdes_guardar');
        });
        /**
         * FIN PLAN DE DESARROLLO ECONOMICO Y SOCIAL
        */

        /**
         * PARA LA ADMINISTRACION DE PEI
         */
        Route::controller(Controlador_Pei::class)->group(function(){
            Route::get('pei/{id}', 'pei')->name('adm_pei');
            //PARA LISTAR LA POLITICA INSTITUCIONAL
            Route::post('listar_politica_institucional', 'listar_politica_institucional')->name('adm_listar_politica_institucional');
            Route::post('politica_institucional_guardar', 'politica_institucional_guardar')->name('adm_politica_institucional_guardar');
            Route::post('politica_institucional_eliminar', 'politica_institucional_eliminar')->name('adm_politica_institucional_eliminar');
            Route::post('politica_institucional_editar', 'politica_institucional_editar')->name('adm_politica_institucional_editar');
            //PARA EL OBJETIVO ESTRATEGICO(CEUB)||OBJETIVO INSTITUCIONAL
            Route::get('objetivos_pei/{id}', 'objetivo_estrategico_sub')->name('adm_objetivo_estrategico_sub');
            Route::post('obj_estrategico_sub_guardar', 'obj_estrategico_sub_guardar')->name('adm_obj_estrategico_sub_guardar');
            Route::post('obj_estrategico_sub_eliminar', 'obj_estrategico_sub_eliminar')->name('adm_obj_estrategico_sub_eliminar');
            Route::post('obj_estrategico_sub_editar', 'obj_estrategico_sub_editar')->name('adm_obj_estrategico_sub_editar');
            Route::post('obj_estrategico_sub_editar_guardar', 'obj_estrategico_sub_editar_guardar')->name('adm_obj_estrategico_sub_editar_guardar');
            //PARA MOSTRAR LOS OBJETIVOS ESTRATEGICOS DE LA SUB
            Route::post('obj_estrategico_sub_mostrar','obj_estrategico_sub_mostrar')->name('adm_obj_estrategico_sub_mostrar');
            //PARA GUARDAR LOS OBJETIVOS ISNTITUCIONALES
            Route::post('obj_institucionales_guardar','obj_institucionales_guardar')->name('adm_obj_institucionales_guardar');
            Route::post('obj_institucionales_eliminar','obj_institucionales_eliminar')->name('adm_obj_institucionales_eliminar');
            Route::post('obj_institucionales_editar','obj_institucionales_editar')->name('adm_obj_institucionales_editar');
            Route::post('obj_institucionales_editar_guardar','obj_institucionales_editar_guardar')->name('adm_obj_institucionales_editar_guardar');
            //PARA LA MATRIZ DE PLANIFICACION
            Route::get('matriz_plan/{id}', 'matriz')->name('adm_matriz');
            Route::post('matriz_obj_estrategico', 'matriz_obj_estrategico')->name('adm_matriz_obj_estrategico');
            Route::post('matriz_obj_estrategico_sub', 'matriz_obj_estrategico_sub')->name('adm_matriz_obj_estrategico_sub');
            Route::post('matriz_obj_estrategico_institucional', 'matriz_obj_estrategico_institucional')->name('adm_matriz_obj_estrategico_institucional');
            //para guardar la matriz de planificacion
            Route::post('matriz_guardar', 'matriz_guardar')->name('adm_matriz_guardar');
            Route::post('matriz_editar','matriz_editar')->name('adm_matriz_editar');
            Route::post('matriz_editar_guardar','matriz_editar_guardar')->name('adm_matriz_editar_guardar');
        });
        /**
         * FIN PARA LA ADMINISTRACION DE PEI
         */

        Route::controller(Controlador_Pdu::class)->group(function(){
            Route::get('pdu/{id}', 'pdu')->name('adm_pdu');

            //PARA LA POLITICA DE DESARROLLO
            Route::post('listar_politica_desarrollo', 'listar_politica_desarrollo')->name('adm_listar_politica_desarrollo');
            Route::post('politica_desarrollo_guardar', 'politica_desarrollo_guardar')->name('adm_politica_desarrollo_guardar');
            Route::post('politica_desarrollo_editar', 'politica_desarrollo_editar')->name('adm_politica_desarrollo_editar');
            Route::post('politica_desarrollo_eliminar', 'politica_desarrollo_eliminar')->name('adm_politica_desarrollo_eliminar');
            //FIN PARA LA POLITICA DE DESARROLLO

            //PARA LOS OBJETIVOS ESTRATEGICOS
            Route::get('objestrategico/{id}', 'objetivo_estrategico')->name('adm_objetivo_estrategico');
            Route::post('obj_estrategico_guardar', 'obj_estrategico_guardar')->name('adm_obj_estrategico_guardar');
            Route::post('obj_estrategico_eliminar', 'obj_estrategico_eliminar')->name('adm_obj_estrategico_eliminar');
            Route::post('obj_estrategico_editar', 'obj_estrategico_editar')->name('adm_obj_estrategico_editar');
            Route::post('obj_estrategico_editar_guardar', 'obj_estrategico_editar_guardar')->name('adm_obj_estrategico_editar_guardar');
            //FIN PARA LOS OBJETIVOS ESTRATEGICOS

        });

        /**
         * FODA
        */
        Route::controller(Controlador_Foda::class)->group(function(){
            Route::get('foda/{id_area_estrategica}/{id_tipo_plan}','listar_foda')->name('adm_listar_foda');
            Route::post('foda_listar', 'foda_listar')->name('adm_foda_listar');
            Route::post('foda_guardar', 'foda_guardar')->name('adm_foda_guardar');
            Route::post('foda_eliminar', 'foda_eliminar')->name('adm_foda_eliminar');
            Route::post('foda_editar', 'foda_editar')->name('adm_foda_editar');
            Route::post('foda_editar_guardar', 'foda_editar_guardar')->name('adm_foda_editar_guardar');
        });
        /**
         * FIN DE FODA
         */

        /**
         * INDICADOR
        */
        Route::controller(Controlador_indicador::class)->group(function(){
            Route::get('indicador/{id}','indicador')->name('adm_indicador');
            Route::post('indicador_guardar','indicador_guardar')->name('adm_indicador_guardar');
            Route::post('indicador_editar','indicador_editar')->name('adm_indicador_editar');
            Route::post('indicador_eliminar','indicador_eliminar')->name('adm_indicador_eliminar');
            Route::post('indicador_editar_guardar','indicador_editar_guardar')->name('adm_indicador_editar_guardar');
        });
        /**
         * FIN DE INDICADOR
         */



        /**
            * FUENTE DE FINANCIAMIENTO
            * TIPO DE FORMULADO
            * TIPO DE PARTIDA
        */
        Route::controller(Controlador_Configuracion::class)->group(function(){
            //PARA EL FUENTE DE FINANCIAMIENTO
            Route::get('fdfinanciamiento', 'fuente_de_financiamiento')->name('adm_fuenteFinanciamiento');
            Route::post('listar_fdfinanciamiento', 'listar_fuente_de_financiamiento')->name('adm_listafuenteFinanciamiento');
            Route::post('fdfinanciamiento_estado', 'fdfinanciamiento_estado')->name('adm_fdfinanciamiento_estado');
            Route::post('fdfinanciamiento_guardar', 'fdfinanciamiento_guardar')->name('adm_fdfinanciamiento_guardar');
            Route::post('fdfinanciamiento_editar', 'fdfinanciamiento_editar')->name('adm_fdfinanciamiento_editar');
            Route::post('fdfinanciamiento_editar_guardar', 'fdfinanciamiento_editar_guardar')->name('adm_fdfinanciamiento_editar_guardar');
            Route::post('fdfinanciamiento_eliminar', 'fdfinanciamiento_eliminar')->name('adm_fdfinanciamiento_eliminar');
            //FIN PARA EL FUENTE DE FINANCIAMIENTO
            //PARA TIPO DE FORMULADO
            Route::get('formulado', 'tipo_formulado')->name('adm_formulado');
            Route::post('formulado_listar', 'tipo_formulado_listar')->name('adm_formulado_listar');
            Route::post('formulado_estado', 'tipo_formulado_estado')->name('adm_formulado_estado');
            Route::post('formulado_guardar', 'tipo_formulado_guardar')->name('adm_formulado_guardar');
            Route::post('formulado_editar', 'tipo_formulado_editar')->name('adm_formulado_editar');
            Route::post('formulado_editar_guardar', 'tipo_formulado_editar_guardar')->name('adm_formulado_editar_guardar');
            Route::post('formulado_eliminar', 'tipo_formulado_eliminar')->name('adm_formulado_eliminar');
            //FIN PARA TIPO DE FORMULADO
            //PARA LAS PARTIDAS
            Route::get('partidas', 'tipo_partida')->name('adm_partida');
            Route::post('partidas_listar', 'tipo_partida_listar')->name('adm_partida_listar');
            Route::post('partidas_guardar', 'tipo_partida_guardar')->name('adm_partida_guardar');
            Route::post('partidas_estado', 'tipo_partida_estado')->name('adm_partida_estado');
            Route::post('partidas_editar', 'tipo_partida_editar')->name('adm_partida_editar');
            Route::post('partidas_editar_guardar', 'tipo_partida_editar_guardar')->name('adm_partida_editar_guardar');
            Route::post('partidas_eliminar', 'tipo_partida_eliminar')->name('adm_partida_eliminar');
            //FIN PARA LAS PARTIDAS
        });
        /**
            * FIN FUENTE DE FINANCIAMIENTO
            * FIN TIPO DE FORMULADO
            * FIN TIPO DE PARTIDA
        */

        /**
         * PARA LA PARTE DE LOS CLASIFICADORES
        */
        Route::controller(Controlador_clasificador::class)->group(function(){

            /**
             * TIPO DE CLASIFICADOR
            */
            Route::get('clasificador', 'clasificador')->name('adm_clasificador');
            Route::post('clasificador_listar', 'clasificador_listar')->name('adm_clasificador_listar');
            Route::post('clasificador_estado', 'clasificador_estado')->name('adm_clasificador_estado');
            Route::post('clasificador_guardar', 'clasificador_guardar')->name('adm_clasificador_guardar');
            Route::post('clasificador_editar', 'clasificador_editar')->name('adm_clasificador_editar');
            Route::post('clasificador_eguardar', 'clasificador_eguardar')->name('adm_clasificador_eguardar');
            Route::post('clasificador_eliminar', 'clasificador_eliminar')->name('adm_clasificador_eliminar');
            /**
             * FINDE TIPO DE CLASIFICADOR
            */

            /**
             * DETALLES CLASIFICADOR
             */
            Route::post('clasificador_detalles', 'clasificador_detalles')->name('adm_clasificador_detalles');
            Route::post('primerCl', 'primerCl')->name('adm_primerCl');
            Route::post('primerCl_editar', 'primerCl_editar')->name('adm_primerCl_editar');
            Route::post('primerCl_eliminar', 'primerCl_eliminar')->name('adm_primerCl_eliminar');
            Route::post('primerCl_estado','primerCl_estado')->name('adm_primerCl_estado');
            /**
             * FINDE DE DETALLES CLASIFICADOR
             */

                /**
                * SEGUNDO CLASIFICADOR
                */
                Route::get('detalles_clasificador/{id}', 'detalles_clasificadorSegundo')->name('adm_clasificador_segundo');
                Route::post('segundo_clasificador', 'segundo_clasificador')->name('adm_segundo_clasificador');
                Route::post('segundo_clasificadorGuardar', 'segundo_clasificadorGuardar')->name('adm_segundo_clasificadorGuardar');
                Route::post('segundo_clasificadorEliminar', 'segundo_clasificadorEliminar')->name('adm_segundo_clasificadorEliminar');
                Route::post('segundo_clasificadorEditar', 'segundo_clasificadorEditar')->name('adm_segundo_clasificadorEditar');
                Route::post('segundo_clasificadorEditarGuardar', 'segundo_clasificadorEditarGuardar')->name('adm_segundo_clasificadorEditarGuardar');
                Route::post('verificarSegundoClasificador', 'verificarSegundoClasificador')->name('adm_verificarSegundoClasificador');

                /**
                 * PARA EL TERCER CLASIFICADOR
                 */
                Route::post('tercer_clasificador', 'tercer_clasificador')->name('adm_tercer_clasificador');
                Route::post('tercer_clasificadorGuardar', 'tercer_clasificadorGuardar')->name('adm_tercer_clasificadorGuardar');
                Route::post('tercer_clasificadorEliminar', 'tercer_clasificadorEliminar')->name('adm_tercer_clasificadorEliminar');
                Route::post('tercer_clasificadorEditar', 'tercer_clasificadorEditar')->name('adm_tercer_clasificadorEditar');
                Route::post('tercer_clasificadorEdGuardar', 'tercer_clasificadorEdGuardar')->name('adm_tercer_clasificadorEdGuardar');

                Route::post('tercer_clasificadorListar', 'tercer_clasificadorListar')->name('adm_tercer_clasificadorListar');
                Route::post('verificar_tercerclasificador', 'verificar_tercerclasificador')->name('adm_verificar_tercerclasificador');

                //detalles para el tercer clasificador
                Route::post('listar_detallesTercerClasificador','listar_detallesTercerClasificador')->name('adm_ListardetallesTercerClasificador');
                Route::post('guardar_detallesTercerClasificador','guardar_detallesTercerClasificador')->name('adm_guardardetallesTercerClasificador');
                Route::post('editar_detallesTercerClasificador','editar_detallesTercerClasificador')->name('adm_editardetallesTercerClasificador');
                Route::post('estadodetallesTercerClasificador','estadodetallesTercerClasificador')->name('adm_estadodetallesTercerClasificador');


                /*
                 * PARA EL CUARTO CLASIFICADOR
                 */
                Route::post('cuarto_clasificador', 'cuarto_clasificador')->name('adm_cuarto_clasificador');
                Route::post('cuarto_clasificadorGuardar', 'cuarto_clasificadorGuardar')->name('adm_cuarto_clasificadorGuardar');
                Route::post('cuarto_clasificadorEditar', 'cuarto_clasificadorEditar')->name('adm_cuarto_clasificadorEditar');
                Route::post('cuarto_clasificadorEGuardar', 'cuarto_clasificadorEGuardar')->name('adm_cuarto_clasificadorEGuardar');
                Route::post('cuarto_clasificadorEliminar', 'cuarto_clasificadorEliminar')->name('adm_cuarto_clasificadorEliminar');

                Route::post('cuarto_clasificadorListar', 'cuarto_clasificadorListar')->name('adm_cuarto_clasificadorListar');
                Route::post('cuarto_clasificadorCuatroDigitos', 'cuarto_clasificadorCuatroDigitos')->name('adm_cuarto_clasificadorCuatroDigitos');

                //detalles para el tercer clasificador
                Route::post('listar_detallescuartoClasificador','listar_detallescuartoClasificador')->name('adm_listarDetallescuartoClasificador');
                Route::post('guardar_detallescuartoClasificador','guardar_detallescuartoClasificador')->name('adm_guardarDetallescuartoClasificador');
                Route::post('editar_detallescuartoClasificador','editar_detallescuartoClasificador')->name('adm_editarDetallescuartoClasificador');
                Route::post('estadodetallesCuartoClasificador','estadodetallesCuartoClasificador')->name('adm_estadodetallesCuartoClasificador');
                /**
                 * PARA EL QUINTO CLASIFICADOR
                */
                Route::post('quinto_clasificador','quinto_clasificador')->name('adm_quinto_clasificador');
                Route::post('quinto_clasificadorGuardar','quinto_clasificadorGuardar')->name('adm_quinto_clasificadorGuardar');
                Route::post('quinto_clasificadorEditar','quinto_clasificadorEditar')->name('adm_quinto_clasificadorEditar');
                Route::post('quinto_clasificadorEGuardar','quinto_clasificadorEGuardar')->name('adm_quinto_clasificadorEGuardar');
                Route::post('quinto_clasificadorEliminar','quinto_clasificadorEliminar')->name('adm_quinto_clasificadorEliminar');

                //detalles para el tercer clasificador
                Route::post('listar_detallesquintoClasificador','listar_detallesquintoClasificador')->name('adm_listarDetallesquintoClasificador');
                Route::post('guardar_detallesquintoClasificador','guardar_detallesquintoClasificador')->name('adm_guardarDetallesquintoClasificador');
                Route::post('editar_detallesquintoClasificador','editar_detallesquintoClasificador')->name('adm_editarDetallesquintoClasificador');
                Route::post('estadodetallesQuintoClasificador','estadodetallesQuintoClasificador')->name('adm_estadodetallesQuintoClasificador');

            /**
             * FIN DE TODOS LOS CLASIFICADORES
            */
        });
        /**
         * FINDE LA PARTE DE CLASIFICADORES
        */


        /**
         * PARA LA PARTE DE CARRERAS UNIDADES ADMINISTRATIVAS Y AREAS
         */
        Route::controller(Controlador_carrera::class)->group(function(){
            Route::get('cua_admin','cua_admin')->name('adm_cua_admin');
            Route::post('cua_adminGuardar','cua_adminGuardar')->name('adm_cua_adminGuardar');
            Route::post('cua_adminEditar','cua_adminEditar')->name('adm_cua_adminEditar');
            Route::post('cua_adminEguardar','cua_adminEguardar')->name('adm_cua_adminEguardar');
            //para redireccionar a las distaicas carrerqas o unidades administrativas
            Route::get('cua_admin/{id}','cua_adminlistar')->name('adm_cua_adminlistar');
            Route::post('cua_carrera_adminListar','cua_carrera_adminListar')->name('adm_cua_carrera_adminListar');
            Route::post('cua_carrera_adminGuardar','cua_carrera_adminGuardar')->name('adm_cua_carrera_adminGuardar');
            Route::post('cua_carrera_adminEstado','cua_carrera_adminEstado')->name('adm_cua_carrera_adminEstado');
            Route::post('cua_carrera_adminEditar','cua_carrera_adminEditar')->name('adm_cua_carrera_adminEditar');
            Route::post('cua_carrera_adminEguardar','cua_carrera_adminEguardar')->name('adm_cua_carrera_adminEguardar');
        });


        /**
         * FIN PARA LA PARTE DE CARRERAS UNIDADES ADMINISTRATIVAS Y AREAS
         */

        /**
         * PARA ASIGNAR LA PARTE DE FINANCIAMIENTOS
        */
        Route::controller(Controlador_asignarFinanciamiento::class)->group(function(){
            Route::get('financiamiento', 'asignarFinanciamiento')->name('adm_asignarFinanciamiento');
            Route::post('listar_gestiones', 'listar_gestiones')->name('adm_listarGestiones');
            Route::post('listar_CarreraUnidad', 'listar_CarreraUnidad')->name('adm_listar_CarreraUnidad');

            //listar
            Route::post('buscador_listado', 'buscador_listado')->name('adm_buscador_listado');

            Route::get('asignarFinanciamiento/{id1}/{id2}', 'asignar_financiamiento')->name('adm_asignar_financiamiento');
            Route::post('listar_cua', 'listar_cua')->name('adm_listarCua');
            Route::post('caja_financiamientoCarrera', 'caja_financiamientoCarrera')->name('adm_caja_financiamientoCarrera');
            Route::post('caja_finaCGuardar', 'caja_finaCGuardar')->name('adm_caja_finaCGuardar');
            Route::post('caja_finaCEditar', 'caja_finaCEditar')->name('adm_caja_finanaciadaCEditar');
        });
        /**
         * FIN PARA ASIGNAR LA PARTE DE FINANCIAMIENTO
        */

        /**
         * PARA HABILITAR LA CONFIGURACION DEL FORMULADO
         */
        Route::controller(Controlador_formulado::class)->group(function(){
            Route::get('habilitar_formulado','habilitar_formulado')->name('adm_formuladoHabiliado');
            Route::post('verificar_formuladoPartida','verificar_formuladoPartida')->name('adm_verificar_formuladoPartida');
            Route::post('mostrar_formuladoAnt','mostrar_formulado_anterior')->name('adm_mostrar_formuladoAnt');
            Route::post('mostrar_clasificador','mostrar_clasificador')->name('adm_mostrar_clasificador');
            Route::post('guardar_conFormulado','guardar_conFormulado')->name('adm_guardar_conFormulado');

            //para editar el formulado ya realizado
            Route::post('editarFormulado','editarFormulado')->name('editarFormulado');
            Route::post('editarFormuladoGuardar','editarFormuladoGuardar')->name('adm_editarFormuladoGuardar');
        });
         /**
         * PARA HABILITAR LA CONFIGURACION DEL FORMULADO
         */

        /**
         * Para la parte de formulacion del plan operativo anual
         */
        Route::controller(Controlador_formulacion::class)->group(function(){
            Route::get('formulaciónPOA', 'formulacion_poa')->name('poa_formulacion');
            Route::post('listarGestionesSP', 'listarGestionesSP')->name('poa_listarGestionesSP');
            Route::get('formulaciónPOA/{formuladoConf_id}/{gestiones_id}', 'formulacionPOA')->name('poa_formulacionPOA');

            //PARA EL FORMULARIO Nº1
            Route::post('formulario1_guardar', 'formulario1_guardar')->name('poa_formulario1Guardar');
            Route::post('formulario1_Editar', 'formulario1_Editar')->name('poa_formulario1Editar');
            Route::post('formulario1_EditarGuardar', 'formulario1_EditarGuardar')->name('poa_form1EditarGuardar');

            //PARA EL FORMULARIO Nº2
            Route::get('formN2/{formulario1_id}/{formuladoTipo_id}', 'formulario2')->name('poa_formulario2');
            Route::get('formN2AE/{formulario1_id}/{areaEstrategica_id}', 'form_areaEstrategicas')->name('poa_formAreaEstrategicas');
            Route::post('guardar_form2', 'guardar_form2')->name('poa_guardarform2');
            Route::post('editar_form2', 'editar_form2')->name('poa_editarform2');
            Route::post('editar_form2guardar', 'editar_form2guardar')->name('poa_editarform2guardar');
            Route::post('validar_existeIndicador', 'validar_existeIndicador')->name('poa_validarExisteIndicador');
            Route::post('validar_IndicadorExiste', 'validar_IndicadorExiste')->name('poa_validarIndicadorExiste');

            //PARA EL FORMULARIO Nº4
            Route::get('fx4/{formulario1_id}/{formuladoTipo_id}', 'formulario4')->name('poa_form4');
            Route::get('fa4/{formulario1_id}/{areaEstrategica_id}','form4AreasEstrategicas')->name('poa_form4AreasEstrategicas');
            Route::post('validarf4f2','validarf4f2')->name('poa_validarf4f2');
            Route::post('guardar_formulario4','guardar_formulario4')->name('poa_guardar_formulario4');
            Route::post('editarform4', 'editarform4')->name('poa_editarform4');
            Route::post('editarform4_guardar', 'editarform4_guardar')->name('poa_editarform4guardar');
            Route::post('validarf4f2edi', 'validarf4f2edi')->name('poa_validarf4f2edi');
        });
        /**
         * Fin de la parte de formulacion del plan operativo anual
         */

        /**
         * PARA EL FORMULARIO Nº5
         */
        Route::controller(Controlador_formulario5::class)->group(function(){
            //PARA EL FORMULARIO Nº5
            Route::get('fx5/{formulario4_id}/{formuladoTipo_id}/{area_estrategica_id}', 'formulario5')->name('poa_form5');
            Route::post('guardar_form5', 'guardar_formulario5')->name('poa_guardar_formulario5');
            Route::post('editar_form5', 'editar_formulario5')->name('poa_editar_formulario5');
            Route::post('editar_guardar_form5', 'editar_guardar_formulario5')->name('poa_editar_guardar_formulario5');
            //Route::get('f5_autocompletado/{escrito}', 'f5_autocompletado')->name('poa_f5_autocompletado');
            Route::post('f5_buscar_clasificador', 'f5_buscar_clasificador')->name('poa_f5_buscar_clasificador');
            Route::post('listar_financiamientof4', 'listar_financiamientof4')->name('poa_listar_financiamientof4');
            Route::post('listar_requerimientos', 'listar_requerimientos')->name('poa_listar_requerimientos');
            Route::post('mostrar_monto_actualAf4', 'mostrar_monto_actualAf4')->name('poa_mostrar_monto_actualAf4');
            Route::post('listar_medida', 'listar_medida')->name('poa_listar_medida');
            Route::post('validar_montoIngresado', 'validar_montoIngresado')->name('poa_validar_montoIngresado');
            Route::post('validar_montoIngresadoMulti', 'validar_montoIngresadoMulti')->name('poa_validar_montoIngresadoMulti');
            Route::post('guardar_requerimientosf5', 'guardar_requerimientosf5')->name('poa_guardar_requerimientosf5');

            //para editar la parte de los requerimientos
            Route::get('fx5/requerimientos/{id}', 'listar_requerimientos_formilario5')->name('req_listar');

            Route::post('req_eliminar','req_eliminar')->name('req_eliminar');
            Route::post('req_editar','req_editar')->name('req_editar');
            Route::post('req_validar','req_validar')->name('req_validar');
            Route::post('req_validar1','req_validar1')->name('req_validar1');
            Route::post('req_guardar_requerimiento_editado','req_guardar_requerimiento_editado')->name('req_guardar_requerimiento_editado');
        });
        /**
         * FIN PARA EL FORMULARIO Nº5
         */

        /**
         * controlador para el formulario del 2 para adelante
         */
        Route::controller(Controlador_formulario2::class)->group(function(){
            Route::get('formNN2/{formulario1_id}/{formuladoTipo_id}', 'formulario2')->name('poaf_fromulario2');

            //asignar financiamiento a un indicador
            Route::post('asigarPresupuestoIndicador','asigarPresupuestoIndicador')->name('poa_asigarPresupuestoIndicador');
            Route::post('verificar_cuanto_en_caja','verificar_cuanto_en_caja')->name('poa_verificar_cuanto_en_caja');
            Route::post('validar_montos_asignar','validar_montos_asignar')->name('poa_validar_montos_asignar');
            Route::post('listar_asignacion_monto','listar_asignacion_monto')->name('poa_listar_asignacion_montor');
            Route::post('guardar_asignacion_monto','guardar_asignacion_monto')->name('poa_guardar_asignacion_monto');
            Route::post('editar_financiamientoMonto','editar_financiamientoMonto')->name('poa_editar_financiamientoMonto');

            //asignar financiamiento restar o sumar
            Route::post('asignar_financiamiento_sumar','asignar_financiamiento_sumar')->name('poa_asignar_fina_sumar');
            Route::post('asignar_financiamiento_restar','asignar_financiamiento_restar')->name('poa_asignar_fina_restar');
            Route::post('guardar_datos_editados_financiamiento','guardar_datos_editados_financiamiento')->name('poa_guardar_datos_editados_financiamiento');
        });
        /**
         * fin controlador para el formulario del 2 para adelante
         */

        /**
          * para el controlador de foda de las carreras y unidad
        */
        Route::controller(Controlador_fodaCarrera::class)->group(function(){
            Route::get('lisFodac/{id_gestiones}/{id_formulario1}', 'listado_fodac')->name('fodac_listado');
            Route::post('guardarFoda_c', 'guardarFoda_c')->name('fodac_guardar');
            Route::post('listarFoda_c', 'listarFoda_c')->name('fodac_listarFoda');
            Route::post('editarFoda_c', 'editarFoda_c')->name('fodac_editarFoda');
            Route::post('editarFoda_guardar', 'editarFoda_guardar')->name('fodac_editarFoda_guardar');
        });
        /**
          * Fin para el controlador de foda de las carreras y unidad
        */

        /**
         * Para la parte de reportes de PDF PDE - PDU
        */
        Route::controller(Controlador_reportesPDF::class)->group(function(){
            Route::get('reportes', 'reportes_pdf')->name('pdf_pei');
            Route::post('reportes_poa', 'reportes_poa')->name('pdf_reportesPoa');

            //generar reporte de matriz de planificacion
            Route::post('matriz_planificacion', 'matriz_planificacionPDF')->name('pdf_matrizPlanificacion');
            Route::post('reporte/matriz_planificacion', 'matriz_pdf')->name('matriz_pdf');

            //importar a pdf la parte de asignacion de montos por gestion
            Route::post('ampgestion','asignacion_montos_por_gestion')->name('pdf_asignacion_montos');

            //para la parte de los reportes de los formularios
            Route::get('reportes_pdf_poa','reportes_pdf_poa')->name('pdf_poa');
            Route::post('tipo_formulados_listar','tipo_formulados_listar')->name('pdf_tipo_formulados_listar');
            Route::post('listar_carreraunidad','listar_carreraunidad')->name('pdf_listar_carreraunidad');
            Route::post('carrera_unidadaarea_formulario','carrera_unidadaarea_formulario')->name('pdf_carrera_unidadaarea_formulario');

            // Para imprimir los formularios
            Route::post('form1_pdf','formulario1_pdf')->name('pdf_form1');
            Route::post('form2_pdf','formulario2_pdf')->name('pdf_form2');
            Route::post('form3_pdf','formulario3_pdf')->name('pdf_form3');
            Route::post('form4_pdf','formulario4_pdf')->name('pdf_form4');
            Route::post('form5_pdf','formulario5_pdf')->name('pdf_form5');
            Route::post('form6_pdf','formulario6_pdf')->name('pdf_form6');
        });
    });
