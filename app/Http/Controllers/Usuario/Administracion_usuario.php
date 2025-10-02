<?php
namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
/**
 * Roles y Permisos
 */
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Administracion_usuario extends Controller
{

    /**
     * PERFIL
     */
    public function perfil()
    {
        $data['menu'] = '0';
        return view('perfil', $data);
    }

    //guardar datos del perfgil
    public function perfil_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'ci'       => 'required|unique:users,ci_persona,' . $request->id,
                'nombres'  => 'required|string',
                'apellido' => 'required',
                'email'    => 'required|email',
            ]);
            if ($validar->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $validar->errors(),
                ];
            } else {
                $usuario           = User::find($request->id);
                $usuario->nombre   = $request->nombres;
                $usuario->apellido = $request->apellido;
                $usuario->email    = $request->email;
                $usuario->celular  = $request->celular;
                if ($usuario->save()) {
                    $data = [
                        'tipo'    => 'success',
                        'mensaje' => 'Se guardo con éxito!',
                    ];
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => 'Ocurrio un error!',
                    ];
                }
            }
            return response()->json($data, 200);
        }
    }

    public function perfil_password(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'password'           => 'required|min:5',
                'confirmar_password' => 'required|min:5|same:password',
            ]);
            if ($validar->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $validar->errors(),
                ];
            } else {
                $usuario           = User::find($request->id);
                $usuario->password = Hash::make($request->password);
                if ($usuario->save()) {
                    $data = [
                        'tipo'    => 'success',
                        'mensaje' => 'Se agregó la nueva contraseña con éxito, vueva a ingresar con la nueva contraseña!',
                    ];
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => 'Ocurrio un error',
                    ];
                }
            }
            return response()->json($data, 200);
        }
    }

    //para guardar imagen
    public function perfil_imagen(Request $request)
    {
        if ($request->ajax()) {
            $id      = $request->id;
            $valores = Validator::make($request->all(), [
                'perfil' => 'required|image',
                'id'     => 'required',
            ]);
            if ($valores->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $valores->errors(),
                ];
            } else {
                if ($request->input('img_ant') != '') {
                    $imagePath = 'perfil/' . $request->input('img_ant');
                    unlink($imagePath);
                }

                $usuario = User::find($id);
                if ($imagen = $request->file('perfil')) {
                    $rutaGuardarImg = 'perfil/';
                    $imagen_perfil  = date('YmdHis') . '.png';
                    $imagen->move($rutaGuardarImg, $imagen_perfil);
                    $usuario->perfil = $imagen_perfil;
                    $usuario->save();
                }

                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se guardo correctamente su perfil !!',
                ];
            }
            return response()->json($data, 200);
        }
    }

    /**
     * FIN DE PERFIL
     */

    /**
     * ADMINISTRACION DE USUARIOS
     */
    //usuarios
    public function usuarios()
    {
        $data['menu']       = '2';
        $data['us_activos'] = User::where('estado', 'activo')
            ->get();
        $data['us_inactivos'] = User::where('estado', 'inactivo')
            ->get();
        $data['roles'] = Role::get();
        return view('administrador.admin_usuarios.usuarios.usuario', $data);
    }
    //admin validar ci
    public function validar_ci(Request $request)
    {
        if ($request->ajax()) {
            $usuario = User::where('ci_persona', 'like', $request->ci)->first();
            if ($usuario) {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ya existe el usuario',
                ];
            } else {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'No existe similar',
                ];
            }
            return response()->json($data, 200);
        }
    }

    //para guardar usuario
    public function usuario_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'ci'       => 'required|unique:users,ci_persona',
                'nombre'   => 'required|string',
                'apellido' => 'required',
                'email'    => 'required|email',
                'usuario'  => 'required',
                'password' => 'required',
            ]);
            if ($validar->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $validar->errors(),
                ];
            } else {
                $usuario                 = new User;
                $usuario->ci_persona     = $request->ci;
                $usuario->nombre         = $request->nombre;
                $usuario->apellido       = $request->apellido;
                $usuario->email          = $request->email;
                $usuario->usuario        = $request->usuario;
                $usuario->remember_token = Str::random(10);
                $usuario->estado         = 'activo';
                $usuario->password       = Hash::make($request->password);

                if ($request->carrera != null || $request->carrera != '') {
                    $usuario->id_unidad_carrera = $request->carrera;
                }

                if ($usuario->save()) {
                    $data = [
                        'tipo'    => 'success',
                        'mensaje' => 'Se guardo con éxito!',
                    ];
                    $usuario->assignRole($request->rol);
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => 'ocurrio un error al guardar!',
                    ];
                }
            }
            return response()->json($data, 200);
        }
    }

    //eliminar uusario
    public function usuario_eliminar(Request $request)
    {
        if ($request->ajax()) {
            $usuario = User::findOrFail($request->id);
            if ($usuario->delete()) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se elimino con éxito',
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ocurrio un error al eliminar',
                ];
            }
            return response()->json($data, 200);
        }
    }

    //para resete password
    public function usuario_reset(Request $request)
    {
        if ($request->ajax()) {
            $usuario = User::findOrFail($request->id);
            if ($usuario) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => $usuario,
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'No existe el usuario solicitado',
                ];
            }
            return response()->json($data, 200);
        }
    }
    //para guardar uusario reset
    public function usuario_reset_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'usuario_r'  => 'required',
                'password_r' => 'required',
            ]);
            if ($validar->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $validar->errors(),
                ];
            } else {
                $usuario_reset           = User::find($request->id_us);
                $usuario_reset->usuario  = $request->usuario_r;
                $usuario_reset->password = Hash::make($request->password_r);
                if ($usuario_reset->save()) {
                    $data = [
                        'tipo'    => 'success',
                        'mensaje' => 'Usuario y contraseña reset!',
                    ];
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => 'Ocurrio un error!',
                    ];
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar uusario
    public function usuario_editar(Request $request)
    {
        if ($request->ajax()) {
            $usuario         = User::find($request->id);
            $data['usuario'] = $usuario;
            $data['roles1']  = Role::get()->pluck('name', 'id');
            $usuario->load('roles');
            $data['tipo_cua_'] = Tipo_CarreraUnidad::get();
            if ($usuario->id_unidad_carrera != null) {
                $car                 = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($usuario->id_unidad_carrera);
                $data['carreras']    = $car;
                $lis_carrera         = UnidadCarreraArea::where('id_tipo_carrera', $car->tipo_Carrera_UnidadaArea->id)->get();
                $data['lis_carrera'] = $lis_carrera;
            } else {
                $data['carreras']    = null;
                $data['lis_carrera'] = null;
            }
            return response()->json($data);
        }
    }

    //para guardar lo editado
    public function usuario_editar_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'ci_e'       => 'required|unique:users,ci_persona,' . $request->us_id_ed,
                'nombre_e'   => 'required',
                'apellido_e' => 'required',
                'email_e'    => 'required|email',
            ]);
            if ($validar->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $validar->errors(),
                ];
            } else {
                $usuario                 = User::find($request->us_id_ed);
                $usuario->nombre         = $request->nombre_e;
                $usuario->apellido       = $request->apellido_e;
                $usuario->email          = $request->email_e;
                $usuario->remember_token = Str::random(10);

                if ($request->carrera_ != null || $request->carrera_ != '') {
                    $usuario->id_unidad_carrera = $request->carrera_;
                }

                if ($usuario->save()) {
                    $data = [
                        'tipo'    => 'success',
                        'mensaje' => 'Se guardo con éxito!',
                    ];
                    $usuario->syncRoles($request->roles_edi);
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => 'Ocurrio un error al editar!',
                    ];
                }
            }
            return response()->json($data, 200);
        }
    }

    //para el estado de usuario
    public function usuario_estado(Request $request)
    {
        if ($request->ajax()) {
            $usuario         = User::find($request->id);
            $estado          = $usuario->estado == 'activo' ? 'inactivo' : 'activo';
            $usuario->estado = $estado;
            if ($usuario->save()) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se cambio el estado con éxito',
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ocurio un error al cambiar el estado',
                ];
            }
            return response()->json($data, 200);
        }
    }

    //para ver con que rol crear
    public function usuario_cua(Request $request)
    {
        if ($request->ajax()) {
            $rol      = Role::find($request->id);
            $tipo_cua = Tipo_CarreraUnidad::get();
            // if($rol->name == 'Administrador'|| $rol->name=='admin'|| $rol->name=='tecnico'||$rol->name == 'administrador'){
            //     $data = mensaje_array('error', 'administrador o tecnico');
            // }else{
            $data = mensaje_array('success', $tipo_cua);
            // }
            return response()->json($data, 200);
        }
    }

    //para listar las carreras
    public function usuario_listar_cua(Request $request)
    {
        if ($request->ajax()) {
            $listar_cua = Tipo_CarreraUnidad::find($request->id);
            $lis_cua    = $listar_cua->carrera_unidad_area;
            if ($listar_cua) {
                $data = [
                    'tipo'     => 'success',
                    'mensaje'  => $lis_cua,
                    'tipo_cua' => $listar_cua,
                ];
            } else {
                $data = mensaje_array('error', 'no existe registros');
            }
            return response()->json($data, 200);
        }
    }

    /**
     * FIN DE ADMINISTRACION DE USUARIOS
     */

    /**
     * ADMINISTRACION DE ROLES
     */
    public function roles()
    {
        $data['roles']    = Role::all();
        $data['permisos'] = Permission::all();
        $data['menu']     = '3';
        return view('administrador.admin_usuarios.roles.roles', $data);
    }
    //para guardar rol
    public function rol_guardar(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'rol' => 'required|unique:roles,name',
        ]);
        if ($validar->fails()) {
            $data = [
                'tipo'    => 'errores',
                'mensaje' => $validar->errors(),
            ];
        } else {
            $rol       = new Role;
            $rol->name = $request->rol;
            $rol->save();
            $rol->syncPermissions($request->permisos);
            $data = [
                'tipo'    => 'success',
                'mensaje' => 'Se creo con éxito!!',
            ];
        }
        return response()->json($data, 200);
    }
    //eliminar rol
    public function rol_eliminar(Request $request)
    {
        if ($request->ajax()) {
            if (Role::findOrFail($request->id)->delete()) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se elimino el rol con éxito',
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ocurrio un error al eliminar',
                ];
            }
            return response()->json($data, 200);
        }
    }
    //editar Rol
    public function rol_editar(Request $request)
    {
        if ($request->ajax()) {
            $data['id']      = $request->id;
            $rol             = Role::find($request->id);
            $data['roles']   = $rol;
            $data['permiso'] = Permission::all()->pluck('name', 'id');
            $rol->load('permissions');
            return view('administrador.admin_usuarios.roles.editar', $data);
        }
    }

    //para guardar lo editado
    public function rol_editar_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'role' => 'required|unique:roles,name,' . $request->id,
            ]);
            if ($validar->fails()) {
                $data = [
                    'tipo'    => 'errores',
                    'mensaje' => $validar->errors(),
                ];
            } else {
                $rol       = Role::find($request->id);
                $rol->name = $request->role;
                $rol->save();
                $rol->syncPermissions($request->permisos_edi);
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se edito con éxito!!',
                ];
            }
            return response()->json($data, 200);
        }
    }

    /**
     * FIN DE ADMINISTRACION DE ROLES
     */

    /**
     * ADMINISTRACION DE PERMISOS
     */
    public function permisos()
    {
        $data = [
            'menu' => '4',
        ];
        return view('administrador.admin_usuarios.permisos.listado_permiso', $data);
    }

    public function crear_permisos(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'permiso' => 'required|unique:permissions,name',
        ]);
        if ($validar->fails()) {
            $data = [
                'tipo'    => 'errores',
                'mensaje' => $validar->errors(),
            ];
        } else {
            $permiso       = new Permission;
            $permiso->name = $request->permiso;
            if ($permiso->save()) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se inserto el permiso con éxito!',
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ocurrio un error al insertar!',
                ];
            }
        }
        return response()->json($data, 200);
    }

    //listar permisos
    public function listar_permisos(Request $request)
    {
        $data = [
            'tipo'  => 'success',
            'datos' => Permission::get(),
        ];
        return response()->json($data, 200);
    }
    //eliminar permisos
    public function eliminar_permisos(Request $request)
    {
        try {
            $id               = $request->input('id');
            $eliminar_permiso = Permission::find($id);
            if ($eliminar_permiso->delete()) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se elimino con éxito!',
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ocurio un error al eliminar!',
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'tipo'    => 'error',
                'mensaje' => 'Ocurio un error al eliminar!',
            ];
        }
        return response()->json($data, 200);
    }
    //editar permiso
    public function editar_permiso(Request $request)
    {
        try {
            $id      = $request->input('id');
            $permiso = Permission::find($id);
            $data    = [
                'tipo'    => 'success',
                'mensaje' => $permiso,
            ];
        } catch (\Throwable $th) {
            $data = [
                'tipo'    => 'error',
                'mensaje' => 'No se encontro el registro!',
            ];
        }
        return response()->json($data, 200);
    }

    //para guardar lo editado
    public function guardar_edi_permiso(Request $request)
    {
        $id      = $request->input('id_permiso');
        $validar = Validator::make($request->all(), [
            'permiso_e' => 'required|unique:permissions,name,' . $id,
        ]);
        if ($validar->fails()) {
            $data = [
                'tipo'    => 'errores',
                'mensaje' => $validar->errors(),
            ];
        } else {
            $permiso       = Permission::find($id);
            $permiso->name = $request->input('permiso_e');
            if ($permiso->update()) {
                $data = [
                    'tipo'    => 'success',
                    'mensaje' => 'Se editó con éxito!',
                ];
            } else {
                $data = [
                    'tipo'    => 'error',
                    'mensaje' => 'Ocurrio un error al editar!',
                ];
            }
        }
        return response()->json($data, 200);
    }
    /**
     * FIN DE ADMINISTRACION DE PERMISOS
     */

}
